<?php

namespace App\Livewire\Campaign;

use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\Campaign;
use Livewire\Component;

class EditCampaign extends Component
{
  use WithFileUploads;

  public $editBasic = false;

  public $editStory = false;

  public $editTarget = false;
  
  public $editAccount = false;

  public $showEditCampaignDialog = false;

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

  public $owner;

  public $editable = false;

  public $previous;

  public $campaignId = 0;

  #[On('edit-detail-campaign')]
  public function editCampaign($campaignId, $editable) {
    $this->campaignId = $campaignId;
    $this->editable = $editable;

    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;

    $campaign = Campaign::find($campaignId);
    $this->previous = $campaign;

    $this->title         = $campaign->title;
    $this->category      = $campaign->category;
    $this->location      = $campaign->location;
    $this->description   = $campaign->description;
    $this->updateplan    = $campaign->updateplan;
    $this->targetfunding = $campaign->targetfunding;
    $this->deadline      = $campaign->deadline;
    $this->accounttype   = $campaign->accounttype;
    $this->accountbank   = $campaign->accountbank;
    $this->accountholder = $campaign->accountholder;
    $this->accountno     = $campaign->accountno;
    $this->address       = $campaign->address;
    $this->photo         = $campaign->photo;
    $this->videolink     = $campaign->videolink;
    $this->owner         = $campaign->owner;

    $this->showEditCampaignDialog = true;
  }

  public function render()
  {
    return view('livewire.campaign.edit-campaign');
  }

  public function campaignCategory()
  {
    return match($this->category) {
      'HEALTH'     => 'Kesehatan',
      'EDUCATION'  => 'Pendidikan',
      'EMERGENCY'  => 'Darurat',
      'DISASTER'   => 'Bencana',
      'PETS'       => 'Hewan Peliharaan',
      'CREATIVITY' => 'Ide Kreatif',
      default      => 'Lain-Lain'
    };
  }

  public function accountType()
  {
    return match($this->accounttype) {
      'PERSONAL'     => 'Individu',
      'ORGANIZATION' => 'Organisasi',
      default        => 'Lain-Lain'
    };
  }

  public function accountBank()
  {
    return match($this->accountbank) {
      'MANDIRI' => 'Bank Mandiri',
      'BRI'     => 'Bank BRI',
      'BNI'     => 'Bank BRI',
      'BCA'     => 'Bank BCA',
      'CIMB'    => 'Bank CIMB Niaga',
      default   => 'Lain-Lain'
    };
  }

  public function basicEdit()
  {
    $this->editBasic   = true;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;
  }

  public function basicDone($save, $campaignId = 0)
  {
    if ($save) {
      $this->validateOnly('title');
      $this->validateOnly('category');
      $this->validateOnly('location');

      $campaign = Campaign::find($campaignId);
      $campaign->title    = $this->title;
      $campaign->category = $this->category;
      $campaign->location = $this->location;
      $campaign->save();
    }
    else {
      $this->title    = $this->previous?->title;
      $this->category = $this->previous?->category;
      $this->location = $this->previous?->location;  
    }

    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;
  }

  
  public function storyEdit()
  {
    $this->editBasic   = false;
    $this->editStory   = true;
    $this->editTarget  = false;
    $this->editAccount = false;
  }

  public function storyDone($save, $campaignId = 0)
  {
    if ($save) {
      $this->validateOnly('description');
      $this->validateOnly('updateplan');

      $campaign = Campaign::find($campaignId);
      $campaign->description = $this->description;
      $campaign->updateplan  = $this->updateplan;
      $campaign->save();
    }
    else {
      $this->description   = $this->previous?->description;
      $this->updateplan    = $this->previous?->updateplan;  
    }

    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;
  }

  public function targetEdit()
  {
    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = true;
    $this->editAccount = false;
  }

  public function targetDone($save, $campaignId = 0)
  {
    if ($save) {
      $this->validateOnly('targetfunding');
      $this->validateOnly('deadline');

      $campaign = Campaign::find($campaignId);
      $campaign->targetfunding = $this->targetfunding;
      $campaign->deadline      = $this->deadline;
      $campaign->save();
    }
    else {
      $this->targetfunding = $this->previous?->targetfunding;
      $this->deadline      = $this->previous?->deadline;
    }

    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;
  }
  public function accountEdit()
  {
    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = true;
  }

  public function accountDone($save, $campaignId = 0)
  {
    if ($save) {
      $this->validateOnly('accounttype');
      $this->validateOnly('accountbank');
      $this->validateOnly('accountholder');
      $this->validateOnly('accountno');
      $this->validateOnly('address');

      $campaign = Campaign::find($campaignId);
      $campaign->accounttype   = $this->accounttype;
      $campaign->accountbank   = $this->accountbank;
      $campaign->accountholder = $this->accountholder;
      $campaign->accountno     = $this->accountno;
      $campaign->address       = $this->address;
      $campaign->save();
    }
    else {
      $this->accounttype   = $this->previous?->accounttype;
      $this->accountbank   = $this->previous?->accountbank;
      $this->accountholder = $this->previous?->accountholder;
      $this->accountno     = $this->previous?->accountno;
      $this->address       = $this->previous?->address;
    }
    $this->editBasic   = false;
    $this->editStory   = false;
    $this->editTarget  = false;
    $this->editAccount = false;
  }
}
