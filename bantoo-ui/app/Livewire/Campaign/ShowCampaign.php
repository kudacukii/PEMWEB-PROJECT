<?php

namespace App\Livewire\Campaign;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ShowCampaign extends Campaign
{  
	public function mount()
  {
    $this->viewPerPage = 5;
    $this->currentRows = 0;
    $this->title = 'Penggalangan Dana Individu';
    $this->status = 'ACTIVE';
    $this->loadMore();
  }

	public function render()
  {
    return view('livewire.campaign.show-campaign');
  }
}
