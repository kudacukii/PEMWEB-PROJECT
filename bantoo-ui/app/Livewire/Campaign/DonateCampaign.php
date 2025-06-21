<?php

namespace App\Livewire\Campaign;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use App\Models\Donation;

class DonateCampaign extends Component
{
  use WithFileUploads;
  public $showDonateCampaignDialog = false;

  public $showDonationSuccessDialog = false;

  public $campaign;

  public $donationtype = 'CHOOSE';

  #[Validate('required', message: 'Alamat pengambilan barang harus diisi')]
  #[Validate('min:10', message: 'Alamat pengambilan barang kurang jelas')]
  public $senderaddress;

  #[Validate('required', message: 'Nama barang harus diisi')]
  #[Validate('min:10',   message: 'Nama barang kurang jelas')]
  public $goodsname;

  #[Validate('required', message: 'Jumlah barang harus diisi')]
  #[Validate('min:10',   message: 'Keterangan jumlah barang kurang jelas')]
  public $quantity;

  #[Validate('required',           message: 'Foto barang harus ada')]
  #[Validate('mimes:jpg,jpeg,png', message: 'Foto barang harus bertipe JPG atau PNG')]
  #[Validate('max:2048',           message: 'Foto barang maksimum berukuran 2MB')]
  #[Validate('image',              message: 'Media tidak dikenali')]
  public $photo;

  #[Validate('required', message: 'Jumlah donasi harus dipilih')]
  #[Validate('gt:0',     message: 'Jumlah donasi tidak bisa kosong')]
  #[Validate('numeric',  message: 'Jumlah donasi harus berupa angka')]
  public $paymentamount = '';

  #[Validate('required', message: 'Metode pembayaran donasi harus dipilih')]
  public $paymentmethod = 'BANK';

  #[Validate('required', message: 'Alat pembayaran donasi harus dipilih')]
  public $paymentchannel = '';

  public $paymentanonim = false;

  public function mount()
  {
    $this->reset();
    
    $this->clearAll();
  }

  public function render()
  {
    return view('livewire.campaign.donate-campaign');
  }

  #[On('make-donation')]
  public function makeDonation($campaign) {
    $this->clearAll();
    $this->campaign = $campaign;
    $this->donationtype = $this->donationTypeOf($campaign);
    $this->showDonateCampaignDialog = true;
  }

  public function sendDonation() {
    $this->validateOnly('senderaddress');
    $this->validateOnly('goodsname');
    $this->validateOnly('quantity');
    $this->validateOnly('photo');

    $photopath = $this->photo->store('donations', 'photos');
    $fields = $this->only([
      'senderaddress',
      'goodsname',
      'quantity'
    ]);
    $fields['campaign_id'] = $this->campaign['id'];
    $fields['photo'] = $photopath;

    Donation::create($fields);

    $this->campaign['donationphoto'] = $photopath;

    $this->showDonateCampaignDialog = false;
    $this->showDonationSuccessDialog = true;
  }

  public function makePayment() {
    $this->validateOnly('paymentamount');
    $this->validateOnly('paymentmethod');
    $this->validateOnly('paymentchannel');

    $fields = $this->only([
      'paymentamount',
      'paymentmethod',
      'paymentchannel',
    ]);

    if (!$this->paymentanonim) {
      $fields['donaturname']  = $this->campaign['donatur'];
      $fields['donaturemail'] = $this->campaign['email'];
    }

    $fields['campaign_id'] = $this->campaign['id'];

    Donation::create($fields);

    $this->showDonateCampaignDialog = false;
    $this->showDonationSuccessDialog = true;
  }

  #[Renderless]
  public function closeAll() 
  {
    $this->clearAll();
    $this->showDonateCampaignDialog = false;
    $this->showDonationSuccessDialog = false;
  }

  #[Renderless]
  public function close() 
  {
    $this->clear();
    $this->showDonateCampaignDialog = false;
  }

  private function donationTypeOf($campaign)
  {
    return match($campaign['category']) {
      'EMERGENCY' => 'CHOOSE',
      'DISASTER'  => 'CHOOSE',
      default     => 'FUND',
    };
  }

  private function clearAll()
  {
    $this->clear();
    
    $this->campaign = [
      'id'            => 0,
      'category'      => 'dummy',
      'title'         => 'dummy',
      'amount'        => 'dummy',
      'target'        => 'dummy',
      'percent'       => 'dummy',
      'donatur'       => 'dummy',
      'donationphoto' => 'dummy',
      'email'         => 'dummy'
    ];
  }

  private function clear()
  {
    $this->resetErrorBag();

    $this->paymentamount  = '';
    $this->paymentmethod  = 'BANK';
    $this->paymentchannel = '';
    $this->paymentanonim  = true;
    $this->senderaddress  = '';
    $this->goodsname      = '';
    $this->quantity       = '';
    $this->photo          = null;
  }
}
