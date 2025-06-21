<?php

namespace App\Models;

use DateTime;
use App\Utils\Helper;
use App\Models\Campaign;

final class Bantoo {
  public static function loadCampaign(int $rowcount, int $userId = 0, string $category='ALL', string $status='ALL'): array
  {
    $result = [];
    $campaigns = $userId === 0 ? Bantoo::queryByCategory($rowcount, $category) : Bantoo::queryByUser($rowcount, $userId, $category, $status);

    foreach ($campaigns as $campaign) {
      $donation = $campaign->donations()->sum('paymentamount');
      $num      = $campaign->donations()->count('paymentamount');
      $dayend   = new DateTime($campaign->deadline);
      $daynow   = new DateTime();
      $interval = $dayend->diff($daynow, true);
      $days     = $interval->format('%a');

      $data = [
      'id'            => $campaign->id,
      'owner'         => $campaign->owner,
      'title'         => $campaign->title,
      'category'      => $campaign->category,
      'location'      => $campaign->location,
      'photo'         => "/images/{$campaign->photo}", 
      'description'   => $campaign->description,
      'updateplan'    => $campaign->updateplan,
      'videolink'     => $campaign->videolink,
      'target'        => Helper::humanize($campaign->targetfunding),
      'deadline'      => $campaign->deadline,
      'address'       => $campaign->address,
      'accounttype'   => $campaign->accounttype,
      'accountbank'   => $campaign->accountbank,
      'accountno'     => $campaign->accountno,
      'accountholder' => $campaign->accountholder,
      'status'        => $campaign->status,
      'amount'        => Helper::humanize($donation),
      'percent'       => ceil(($donation/$campaign->targetfunding)*100),
      'likes'         => rand(100,500),
      'donation'      => $num,
      'dayleft'       => $days,
      ];
      array_push($result, $data);
    }

    return $result;
  }

  private static function queryByUser(int $rowcount, int $userId = 0, string $category, string $status)
  {
    return Campaign::
    ownedBy($userId)
    ->ofCategory($category)
    ->withStatus($status)
    ->latest()
    ->take($rowcount)
    ->get();
  }

  private static function queryByCategory(int $rowcount, string $category)
  {
    return Campaign::
      isActive()
      ->ofCategory($category)
      ->latest()
      ->take($rowcount)
      ->get();
  }
}
