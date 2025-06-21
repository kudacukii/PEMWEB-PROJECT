<?php

namespace App\Livewire\Campaign;

use Livewire\Component;
use App\Models\Bantoo;
use Illuminate\Support\Facades\Auth;

abstract class Campaign extends Component
{
  public $viewPerPage = 5;

  public $currentRows = 0;

  public int $userId = 0;

  public string $category = 'ALL';

  public string $status = 'ALL';

  public string $title = '???';

	public $campaigns;

  public function donate($campaignId)
  {
    if (Auth::guest()) {
      $this->redirectRoute('home');
      return;
    };

    $campaign = $this->campaigns[$campaignId];
    $campaign['donatur']       = Auth::user()->name;
    $campaign['email']         = Auth::user()->email;
    $campaign['donationphoto'] = 'donations/dummy';

    $this->dispatch('make-donation', campaign: $campaign)->to(DonateCampaign::class);
  }

  public function view($campaignId)
  {
    if (Auth::guest()) {
      $this->redirectRoute('home');
      return;
    };

    $this->dispatch('view-detail-campaign', campaignId: $campaignId)->to(ViewCampaign::class);
  }

  public function edit($campaignId, $editable)
  {
    if (Auth::guest()) {
      $this->redirectRoute('home');
      return;
    };

    $this->dispatch('edit-detail-campaign', campaignId: $campaignId, editable: $editable)->to(EditCampaign::class);
  }

  public function loadMore() {
    $this->currentRows += $this->viewPerPage;
    $this->loadCampaign();
    $this->currentRows = count($this->campaigns);
  }

  public function changeCategoryTo($category)
  {
    $this->category = $category;
    $this->loadCampaign();
  }

  private function loadCampaign()
  {
    $this->campaigns = Bantoo::loadCampaign($this->currentRows, userId: $this->userId, category: $this->category, status: $this->status);
  }
}
