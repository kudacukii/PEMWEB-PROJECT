<?php

namespace App\Livewire\Campaign;

use App\Models\Campaign;
use Livewire\Component;
use Livewire\Attributes\On;

class ListCampaign extends Component
{
  public $campaigns = [];

  #[On('campaign-updated')]  
  public function donothing()
  {}

  public function mount()
  {
    $this->campaigns = Campaign::latest()->get();
  }

  public function render()
  {
    return view('livewire.campaign.list-campaign');
  }

  public function viewDetail($campaignId)
  {
    $this->dispatch('view-detail-campaign', campaignId: $campaignId)->to(ViewCampaign::class);
  }

  public function continue($campaignId)
  {
    $this->approve($campaignId);
  }

  public function approve($campaignId)
  {
    $campaign = Campaign::find($campaignId);
    $campaign->status = 'ACTIVE';
    $campaign->save();
    $this->dispatch("campaign-updated");
  }

  public function reject($campaignId)
  {
    $campaign = Campaign::find($campaignId);
    $campaign->status = 'REJECTED';
    $campaign->save();
    $this->dispatch("campaign-updated");
  }

  public function suspend($campaignId)
  {
    $campaign = Campaign::find($campaignId);
    $campaign->status = 'SUSPEND';
    $campaign->save();
    $this->dispatch("campaign-updated");
  }

  public function complete($campaignId)
  {
    $campaign = Campaign::find($campaignId);
    $campaign->status = 'COMPLETE';
    $campaign->save();
    $this->dispatch("campaign-updated");
  }
  public function terminate($campaignId)
  {
    $campaign = Campaign::find($campaignId);
    $campaign->status = 'TERMINATE';
    $campaign->save();
    $this->dispatch("campaign-updated");
  }
}
