<?php

namespace App\Livewire\Campaign;

use App\Models\Bantoo;
use Livewire\Attributes\On;

class LatestCampaign extends Campaign
{
  public function mount()
  {
    $this->viewPerPage = 3;
    $this->status = 'ACTIVE';
    $this->loadMore();
  }

  public function render()
  {
    return view('livewire.campaign.latest-campaign');
  }
}

