<?php

namespace App\Livewire\Campaign;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;

class CreateCampaign extends Component
{
  use WithFileUploads;

  public $currentStep = 1;

  #[Validate('required', message: 'Penggalangan dana harus memiliki judul')]
  #[Validate('max:60',   message: 'Panjang judul maksimal 60 karakter')]
  public $title;

  #[Validate('required', message: 'Harus memilih salah satu kategori')]
  public $category;

  #[Validate('required', message: 'Lokasi wajib diisi')]
  #[Validate('max:100',  message: 'Nama Lokasi maksimum 100 karakter')]
  public $location;

  #[Validate('required',           message: 'Gambar utama penggalangan dana wajib ada')]
  #[Validate('mimes:jpg,jpeg,png', message: 'Gambar utama harus bertipe JPG atau PNG')]
  #[Validate('max:2048',           message: 'Gambar utama maksimum berukuran 1MB')]
  #[Validate('image',              message: 'Media gambar utama tidak dikenali')]
  public $photo;

  #[Validate('required', message: 'Penggalangan dana harus memiliki deskripsi')]
  #[Validate('min:300',  message: 'Panjang deskripsi minimal 300 karakter')]
  #[Validate('max:1024', message: 'Panjang deskripsi maksimal 1024 karakter')]
  public $description;

  #[Validate('nullable')]  
  #[Validate('max:1024', message: 'Panjang rencana pembaruan maksimal 1024 karakter')]
  public $updateplan;

  #[Validate('nullable')]
  #[Validate('url', message: 'Tautan video harus valid URL')]
  public $videolink;

  #[Validate('required',       message: 'Target pengumpulan dana harus diisi')]
  #[Validate('numeric',        message: 'Target pengumpulan dana harus berupa angka')]
  #[Validate('min:1000000',    message: 'Target pengumpulan dana minimal Rp. 1 juta,-')]
  #[Validate('max:1000000000', message: 'Target pengumpulan dana maksimal Rp. 1 milyar,-')]
  public $targetfunding;

  #[Validate('required',    message: 'Tenggat hari pengumpulan dana harus diisi')]
  #[Validate('date',        message: 'Tenggat hari pengumpulan dana harus berupa tanggal')]
  #[Validate('after:today', message: 'Tenggat hari pengumpulan dana harus sesudah tanggal pembuatan')]
  public $deadline;

  #[Validate('required', message: 'Tipe penerima dana harus dipilih')]
  public $accounttype;

  #[Validate('required', message: 'Bank harus dipilih')]
  public $accountbank;

  #[Validate('required', message: 'Nama Pemilik Rekening harus diisi')]
  public $accountholder;

  #[Validate('required', message: 'Nomor rekening harus diisi')]
  public $accountno;

  #[Validate('required', message: 'Alamat pengiriman harus diisi')]
  public $address = 'N/A';
  
  #[Validate('required', message: 'Harus menyetujui saran dan ketentuan yang berlaku')]
  public $agreement;

  public $campaign = null;

  public function render()
  {
    return view('livewire.campaign.create-campaign');
  }

  private function validateBasicInfo()
  {
    $this->validateOnly('title');
    $this->validateOnly('category');
    $this->validateOnly('location');
    $this->validateOnly('photo');

    if (($this->category == 'EMERGENCY' || $this->category == 'DISASTER') && $this->address == 'N/A') {
      $this->address = null;
    }

    $this->currentStep = 2;
  }

  private function validateDetailCampaign()
  {
    $this->validateOnly('description');
    $this->validateOnly('updateplan');
    $this->validateOnly('videolink');
    $this->currentStep = 3;
  }

  private function validateFundTarget()
  {
    $this->validateOnly('targetfunding');
    $this->validateOnly('deadline');
    $this->validateOnly('address');
    $this->currentStep = 4;
  }

  private function validateBankAccount()
  {
    $this->validateOnly('accounttype');  
    $this->validateOnly('accountbank');  
    $this->validateOnly('accountno');
    $this->validateOnly('accountholder');
    $this->currentStep = 5;
  }

  private function submitForm()
  {
    if ($this->category != 'EMERGENCY' && $this->category != 'DISASTER') {
      $this->address = 'N/A';
    }

    // validate all fields
    $this->validate();

    $photopath = $this->photo->store('campaigns', 'photos');
    
    $fields = $this->all();
    $fields['owner'] = Auth::user()->id;
    $fields['photo'] = $photopath;

    $this->campaign = Campaign::create($fields);

    $this->currentStep = 6;

    $this->modal('success')->show();
  }

  private function closeModal()
  {
    $this->currentStep = 1;
    $this->campaign = null;
    $this->reset();

    $this->modal('success')->close();
  }

  public function share()
  {
    $this->closeModal();
    return redirect()->to('/home');
  }

  public function preview()
  {
    $id = $this->campaign->id;
    $this->closeModal();
    return redirect()->to("/campaign/view/" . $id);
  }

  public function close()
  {
    $this->closeModal();
    return redirect()->to("/home");
  }

  public function back()
  {
    $this->currentStep -= 1;
    if ($this->currentStep < 1)
      $this->currentStep = 1;
  }

  public function next()
  {

    switch ($this->currentStep) {
      case 1:
        $this->validateBasicInfo();
        break;
      case 2:
        $this->validateDetailCampaign();
        break;
      case 3:
        $this->validateFundTarget();
        break;
      case 4:
        $this->validateBankAccount();
        break;
      case 5:
        $this->submitForm();
        break;
    }
  }
}
