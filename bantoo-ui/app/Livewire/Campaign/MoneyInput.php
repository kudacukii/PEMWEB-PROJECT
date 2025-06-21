<?php

namespace App\Livewire\Campaign;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class MoneyInput extends Component
{
  #[Modelable]
  public $unmaskedValue = '';
  public $id = '';
  public $name = '';
  public $currencySign = 'Rp. ';
  public $placeholder = '';
  public $required = true;
  public $disabled = false;

  public function render()
  {
    return view('livewire.campaign.money-input');
  }

  public function rendered()
  {
    $this->dispatch('money-input-updated', id: $this->id, value: $this->unmaskedValue);
  }
}
