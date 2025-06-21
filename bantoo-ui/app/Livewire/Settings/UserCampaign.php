<?php

namespace App\Livewire\Settings;

use App\Models\Bantoo;
use App\Livewire\Campaign\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserCampaign extends Campaign
{
  public function mount(): void
  {
    $this->viewPerPage = 5;
    $this->currentRows = 0;
    $this->title       = "Penggalangan Dana Saya";
    $this->userId      = Auth::user()->id;
    $this->loadMore();

  }

  public function render()
  {
    return view('livewire.campaign.show-campaign');
  }
}
