<div>
  <flux:modal class="dialog !overflow-scroll min-w-1/2" name="edit-campaign" wire:model.self="showEditCampaignDialog">
  <div class="pt-8">
    <div class="info-section">
      <div class="section-header">Informasi Dasar Penggalangan Dana</div>
      <div class="{{ $editBasic && $editable ? 'hide' : 'show'}}">
        @if ($editable)
        <div class="section-action">
          <flux:icon.pencil-square variant="mini" class="cursor-pointer text-blue-500" wire:click.prevent="basicEdit"/>
        </div>
        @endif
      <div class="p-2">
          <flux:label>Judul</flux:label>
          <flux:text>{{ $title }}</flux:text>
        </div>
        <div class="p-2">
          <flux:label>Kategori</flux:label>
          <flux:text>{{ $this->campaignCategory($this->category) }}</flux:text>
        </div>
        <div class="p-2">
        <flux:label>Lokasi</flux:label>
            <flux:text>{{ $location }}</flux:text>
        </div>
      </div>
      <div class="{{ $editBasic && $editable ? 'show' : 'hide'}}">
        <div class="section-action">
          <flux:icon.document-check variant="mini" class="cursor-pointer text-green-500" square wire:click.prevent="basicDone(true, {{ $campaignId }})"/>
          <flux:icon.x-mark variant="mini" class="cursor-pointer text-red-500" square wire:click.prevent="basicDone(false)"/>
        </div>
        <div class="p-2">
          <flux:input
                wire:model="title"
                placeholder="Contoh: Bantu Sarah melawan kanker"
                label="Judul Penggalangan Dana"
                description="Buat judul yang jelas dan deskriptif (maks. 60 karakter)"
            />
        </div>
        <div class="p-2">
          <flux:field>
            <flux:label>Kategori</flux:label>
            <fieldset class="button-group grid-cols-3 gap-3">
              <input  id="c01" type="radio" name="category" value="HEALTH"    wire:model="category">
              <label for="c01">Kesehatan</label>
              <input  id="c02" type="radio" name="category" value="EDUCATION" wire:model="category">
              <label for="c02">Pendidikan</label>
              <input  id="c03" type="radio" name="category" value="EMERGENCY" wire:model="category">
              <label for="c03">Darurat</label>
              <input  id="c04" type="radio" name="category" value="DISASTER"  wire:model="category">
              <label for="c04">Bencana</label>
              <input  id="c05" type="radio" name="category" value="PETS"       wire:model="category">
              <label for="c05">Hewan Peliharaan</label>
              <input  id="c06" type="radio" name="category" value="CREATIVITY" wire:model="category">
              <label for="c06">Ide Kreatif</label>
            </fieldset>
            <flux:error name="category"/>
          </flux:field>
        </div>
        <div class="p-2">
          <flux:input
            wire:model="location"
            placeholder="Kota, Propinsi"
            label="Lokasi Penggalangan Dana"
            description="Sebutkan lokasi penggalangan dana dengan jelas (maks. 100 karakter)"
          />
        </div>
      </div>
    </div>
    <div class="info-section">
      <div class="section-header">Ceritakan Kisah Anda</div>
      <div class="{{ $editStory && $editable ? 'hide' : 'show'}}">
        @if ($editable)
        <div class="section-action">
          <flux:icon.pencil-square variant="mini" class="cursor-pointer text-blue-500" wire:click.prevent="storyEdit"/>
        </div>
        @endif
        <div class="p-2">
          <flux:label>Deskripsi Penggalangan</flux:label>
          <flux:text>{{ $description }}</flux:text>
        </div>      
        <div class="p-2">
          <flux:label>Rencana Pengkinian</flux:label>
          <flux:text>{{ $updateplan }}</flux:text>
        </div>
      </div>
      <div class="{{ $editStory && $editable ? 'show' : 'hide'}}">
        <div class="section-action">
          <flux:icon.document-check variant="mini" class="cursor-pointer text-green-500" square wire:click.prevent="storyDone(true, {{ $campaignId }})"/>
          <flux:icon.x-mark variant="mini" class="cursor-pointer text-red-500" square wire:click.prevent="storyDone(false)"/>
        </div>
        <div class="p-2">
          <flux:textarea
            wire:model="description"
            placeholder="Kota, Propinsi"
            label="Cerita Penggalangan Dana*"
            description="Cerita yang baik meningkatkan peluang keberhasilan (Min, 300 karakter)."
          />
        </div>
        <div class="p-2">
          <flux:textarea
            wire:model="updateplan"
            placeholder="Bagaimana Anda akan memberikan update kepada donatur? (Contoh: setiap minggu, setelah mencapai target tertentu, dll)"
            label="Rencana Update"
          />
        </div>
      </div>
    </div>
    <div class="info-section">
      <div class="section-header">Target Penggalangan Dana</div>
      <div class="{{ $editTarget && $editable ? 'hide' : 'show'}}">
        @if ($editable)
        <div class="section-action">
          <flux:icon.pencil-square variant="mini" class="cursor-pointer text-blue-500" wire:click.prevent="targetEdit"/>
        </div>
        @endif
        <div class="p-2">
          <flux:label>Target Pengumpulan Dana</flux:label>
          <flux:text>{{ $targetfunding }}</flux:text>
        </div>
        <div class="p-2">
        <flux:label>Batas Waktu</flux:label>
          <flux:text>{{ $deadline }}</flux:text>
        </div>
        @if ($category === 'EMERGENCY' || $category === 'DISASTER')
        <div class="p-2">
          <flux:label>Alamat Penerimaan Barang</flux:label>
          <flux:text>{{ $address }}</flux:text>
        </div>
        @endif
      </div>
      <div class="{{ $editTarget && $editable ? 'show' : 'hide'}}">
        <div class="section-action">
          <flux:icon.document-check variant="mini" class="cursor-pointer text-green-500" square wire:click.prevent="targetDone(true, {{ $campaignId }})"/>
          <flux:icon.x-mark variant="mini" class="cursor-pointer text-red-500" square wire:click.prevent="targetDone(false)"/>
        </div>
        <div class="p-2">
          <flux:input
            wire:model="targetfunding"
            placeholder="Contoh: 50.000.000,-"
            label="Target Pengumpulan Dana"
            description="Tentukan jumlah yang realistis untuk kebutuhan Anda"
          />
        </div>
        <div class="p-2">
          <flux:input
            wire:model="deadline"
            label="Batas Waktu"
            type="date"
            description="Batas waktu pengumpulan dana 90 hari sejak disetujui"
          />
        </div>
        @if ($category == 'EMERGENCY' || $category == 'DISASTER')
        <div class="p-2">
          <flux:textarea
            wire:model="address"
            placeholder="Jalan, No Bangunan, RT/RW, Desa, Kecamatan, Kota, Propinsi, Kode Pos"
            label="Alamat Penerima Donasi Barang"
            description="Tulis alamat penerimaan donasi barang dengan lengkap dan jelas"
          />
        </div>
          @endif
      </div>  
    </div>
    <div class="info-section">
      <div class="section-header">Informasi Pencairan Dana</div>
      <div class="{{ $editAccount && $editable ? 'hide' : 'show'}}">
        @if ($editable)
        <div class="section-action">
          <flux:icon.pencil-square variant="mini" class="cursor-pointer text-blue-500" wire:click.prevent="accountEdit"/>
        </div>
        @endif
        <div class="p-2">
          <flux:label>Tipe Penerima</flux:label>
          <flux:text>{{ $this->accountType() }}</flux:text>
        </div>
        <div class="p-2">
          <flux:label>Rekening Bank</flux:label>
          <flux:text>{{ $this->accountBank() }}</flux:text>
        </div>
        <div class="p-2">
        <flux:label>Nomor Rekening</flux:label>
        <flux:text>{{ $accountno }}</flux:text>
        </div>
        <div class="p-2">
        <flux:label>Pemilik Rekening</flux:label>
        <flux:text>{{ $accountholder }}</flux:text>
        </div>
      </div>
      <div class="{{ $editAccount && $editable ? 'show' : 'hide'}}">
        <div class="section-action">
          <flux:icon.document-check variant="mini" class="cursor-pointer text-green-500" square wire:click.prevent="accountDone(true, {{ $campaignId }})"/>
          <flux:icon.x-mark variant="mini" class="cursor-pointer text-red-500" square wire:click.prevent="accountDone(false)"/>
        </div>
        <div class="p-2">
          <flux:field>
            <flux:label>Tipe Penerima</flux:label>
            <fieldset class="button-group grid-cols-2 gap-4">
              <input  id="account01" type="radio" name="accounttype" value="PERSONAL" wire:model="accounttype">
              <label for="account01" class="rounded-lg px-4 py-3 text-left"><i class="fas fa-user mr-2"></i> Individu</label>
              <input  id="account02" type="radio" name="accounttype" value="ORGANIZATION"  wire:model="accounttype">
              <label for="account02" class="rounded-lg px-4 py-3 text-left"><i class="fas fa-building mr-2"></i> Organisasi</label>
            </fieldset>
          </flux:field>
          <flux:error name="accounttype"/>
        </div>
        <div class="p-2">
          <flux:field>
            <flux:label>Rekening Bank</flux:label>
            <fieldset class="button-group grid-cols-3 gap-3">
              <input  id="bank02" type="radio" name="accountbank" value="MANDIRI" wire:model="accountbank">
              <label for="bank02" class="rounded-full px-4 py-3 text-center">Mandiri</label>

              <input  id="bank03" type="radio" name="accountbank" value="BRI" wire:model="accountbank">
              <label for="bank03" class="rounded-full px-4 py-3 text-center">BRI</label>

              <input  id="bank04" type="radio" name="accountbank" value="BNI" wire:model="accountbank">
              <label for="bank04" class="rounded-full px-4 py-3 text-center">BNI</label>

              <input  id="bank01" type="radio" name="accountbank" value="BCA" wire:model="accountbank">
              <label for="bank01" class="rounded-full px-4 py-3 text-center">BCA</label>

              <input  id="bank05" type="radio" name="accountbank" value="CIMB" wire:model="accountbank">
              <label for="bank05" class="rounded-full px-4 py-3 text-center">CIMB Niaga</label>

              <input id="bank06" type="radio" name="accountbank" value="OTHER" wire:model="accountbank">
              <label for="bank06" class="rounded-full px-4 py-3 text-center">Lainnya</label>
            </fieldset>
          </flux:field>
          <flux:error name="accountbank"/>
        </div>
        <div class="p-2">
          <flux:input wire:model="accountno" label="Nomor Rekening"/>
        </div>
        <div class="p-2">
          <flux:input wire:model="accountholder" label="Nama Pemilik Rekening" placeholder="Harus sama dengan nama di rekening bank" />
        </div>
      </div>
    </div>
    <div class="info-section">
      <div class="section-header">Media</div>
      <div class="p-2">
        <flux:label>Foto</flux:label>
        <img src="/images/{{ $photo }}" class="rounded-md max-w-80" />
      </div>
      @if (str_starts_with($videolink, 'https'))
      <div class="p-2">
        <flux:label>Video</flux:label>
        <x-embed url="{{ $videolink }}" />
      </div>
      @endif
    </div>
    <div class="mt-6 flex flex-row justify-center">
      <flux:button x-on:click="$wire.showEditCampaignDialog = false">Tutup</flux:button>
    </div>
  </div>
  </flux:modal>
</div>
