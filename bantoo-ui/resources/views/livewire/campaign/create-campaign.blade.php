<!-- Create Campaign Section -->
<div class="py-8">
  <div class="mx-auto px-4">
    <div class="dialog">
      <!-- Progress Steps -->
      <div class="wizard-progress">
        <div>
          <div>
            <span class="step-indicator {{ $currentStep == 1 ?  'active' : ($currentStep > 1 ? 'completed' : '') }}">1</span>
            <span class="step-indicator {{ $currentStep == 2 ?  'active' : ($currentStep > 2 ? 'completed' : '') }}">2</span>
            <span class="step-indicator {{ $currentStep == 3 ?  'active' : ($currentStep > 3 ? 'completed' : '') }}">3</span>
            <span class="step-indicator {{ $currentStep == 4 ?  'active' : ($currentStep > 4 ? 'completed' : '') }}">4</span>
            <span class="step-indicator {{ $currentStep == 5 ?  'active' : ($currentStep > 5 ? 'completed' : '') }}">5</span>
          </div>
        </div>
        <div>
          <span class="{{ $currentStep == 1 ?  'text-blue-600' : ''}}">Informasi Dasar</span>
          <span class="{{ $currentStep == 2 ?  'text-blue-600' : ''}}">Detail Penggalangan</span>
          <span class="{{ $currentStep == 3 ?  'text-blue-600' : ''}}">Target Dana</span>
          <span class="{{ $currentStep == 4 ?  'text-blue-600' : ''}}">Pencairan Dana</span>
          <span class="{{ $currentStep == 5 ?  'text-blue-600' : ''}}">Persetujuan</span>
        </div>
      </div>
      <!-- Form Steps -->
      <div class="p-16">
        <div class="form-step {{ $currentStep == 1 ? 'active' : '' }}">
          <h2 class="text-2xl font-bold mb-6">Informasi Dasar Penggalangan Dana</h2>                        
          <div class="mb-6">
            <flux:input
              wire:model="title"
              placeholder="Contoh: Bantu Sarah melawan kanker"
              label="Judul Penggalangan Dana*"
              description="Buat judul yang jelas dan deskriptif (maks. 60 karakter)"
            />
          </div>
          <div class="mb-6">
            <flux:field>
              <flux:label>Kategori*</flux:label>
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
          <div class="mb-6">
            <flux:input
              wire:model="location"
              placeholder="Kota, Propinsi"
              label="Lokasi Penggalangan Dana*"
              description="Sebutkan lokasi penggalangan dana dengan jelas (maks. 100 karakter)"
            />
          </div>
          <div class="mb-6">
            <flux:label>Gambar Utama*</flux:label>
            <div class="image-upload">
              <input
                id="campaign_photo"
                type="file"
                accept="image/*"
                wire:model="photo"
              />
              <label for="campaign_photo">
                @if (!$photo)
                  <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                  <p class="font-medium">Unggah gambar utama</p>
                  <p class="text-sm text-gray-500">Format JPG, PNG (maks. 5MB)</p>
                  <p class="text-sm text-blue-500 mt-2">Pilih dari komputer</p>
                  @else
                  <img src="{{ $photo->temporaryUrl() }}">
                @endif
                <flux:error name="photo"/>
              </label>
            </div>
          </div>
          <div class="flex justify-end">
            <flux:button variant="ghost" icon:trailing="arrow-right" wire:click="next">Lanjutkan</flux:button>
          </div>
        </div>

        <!-- Form Steps -->
        <div class="form-step {{ $currentStep == 2 ? 'active' : '' }}">
          <h2 class="text-2xl font-bold mb-6">Ceritakan Kisah Anda</h2>
          <div class="mb-6">
            <flux:textarea
              wire:model="description"
              placeholder="Kota, Propinsi"
              label="Cerita Penggalangan Dana*"
              description="Cerita yang baik meningkatkan peluang keberhasilan (Min, 300 karakter)."
            />
          </div>
          
          <div class="mb-6">
            <flux:textarea
              wire:model="updateplan"
              placeholder="Bagaimana Anda akan memberikan update kepada donatur? (Contoh: setiap minggu, setelah mencapai target tertentu, dll)"
              label="Rencana Update"
            />
          </div>
          
          <div class="mb-6">
            <flux:input
              wire:model="videolink"
              placeholder="Tempelkan link YouTube atau Vimeo"
              label="Tambahkan Video"
              description="Video dapat meningkatkan kepercayaan donatur hingga 80%"
            />
          </div>
          <div class="flex justify-between">
          <flux:button variant="ghost" icon="arrow-left" wire:click="back">Kembali</flux:button>
          <flux:button variant="ghost" icon:trailing="arrow-right" wire:click="next">Lanjutkan</flux:button>
          </div>
        </div>

        <!-- Form Steps -->
        <div class="form-step {{ $currentStep == 3 ? 'active' : '' }}">
          <h2 class="text-2xl font-bold mb-6">Target Penggalangan Dana</h2>
          <div class="mb-6">
            <flux:input
              wire:model="targetfunding"
              placeholder="Contoh: 50.000.000,-"
              label="Target Pengumpulan Dana*"
              description="Tentukan jumlah yang realistis untuk kebutuhan Anda"
            />
          </div>
          <div class="mb-6">
            <flux:input
              wire:model="deadline"
              label="Batas Waktu*"
              type="date"
              description="Batas waktu pengumpulan dana 90 hari sejak disetujui"
            />
          </div>
          @if ($category == 'EMERGENCY' || $category == 'DISASTER')
          <div class="mb-6">
            <flux:textarea
              wire:model="address"
              placeholder="Jalan, No Bangunan, RT/RW, Desa, Kecamatan, Kota, Propinsi, Kode Pos"
              label="Alamat Penerima Donasi Barang*"
              description="Tulis alamat penerimaan donasi barang dengan lengkap dan jelas"
            />
          </div>
          @endif
          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Biaya Platform</label>
            <div class="p-4 rounded-lg">
              <div class="flex justify-between mb-2">
                <span>Biaya layanan Bantoo!</span>
                <span>5% dari dana terkumpul</span>
              </div>
              <div class="flex justify-between">
                <span>Biaya transaksi pembayaran</span>
                <span>2.9% + Rp2,500 per transaksi</span>
              </div>
              <p class="text-sm text-gray-500 mt-2">Biaya akan dipotong dari dana yang terkumpul.</p>
            </div>
          </div>
          <div class="flex justify-between">
            <flux:button variant="ghost" icon="arrow-left" wire:click="back">Kembali</flux:button>
            <flux:button variant="ghost" icon:trailing="arrow-right" wire:click="next">Lanjutkan</flux:button>
          </div>
        </div>

        <!-- Form Steps -->
        <div class="form-step {{ $currentStep == 4 ? 'active' : '' }}">
          <h2 class="text-2xl font-bold mb-6">Informasi Pencairan Dana</h2>
          <div class="mb-6">
            <flux:field>
              <flux:label>Tipe Penerima*</flux:label>
              <fieldset class="button-group grid-cols-2 gap-4" wire:model="accounttype">
                <input id="account01" type="radio" name="accounttype" value="PERSONAL" required>
                <label for="account01" class="rounded-lg px-4 py-3 text-left"><i class="fas fa-user mr-2"></i> Individu</label>
                <input id="account02" type="radio" name="accounttype" value="ORGANIZATION">
                <label for="account02" class="rounded-lg px-4 py-3 text-left"><i class="fas fa-building mr-2"></i> Organisasi</label>
              </fieldset>
            </flux:field>
            <flux:error name="accounttype"/>
          </div>
          <div class="mb-6">
            <flux:field>
              <flux:label>Rekening Bank*</flux:label>
              <fieldset class="button-group grid-cols-3 gap-3" wire:model="accountbank">
                <input id="bank02" type="radio" name="accountbank" value="MANDIRI" required>
                <label for="bank02" class="rounded-full px-4 py-3 text-center">Mandiri</label>

                <input id="bank03" type="radio" name="accountbank" value="BRI">
                <label for="bank03" class="rounded-full px-4 py-3 text-center">BRI</label>

                <input id="bank04" type="radio" name="accountbank" value="BNI">
                <label for="bank04" class="rounded-full px-4 py-3 text-center">BNI</label>

                <input id="bank01" type="radio" name="accountbank" value="BCA">
                <label for="bank01" class="rounded-full px-4 py-3 text-center">BCA</label>

                <input id="bank05" type="radio" name="accountbank" value="CIMB">
                <label for="bank05" class="rounded-full px-4 py-3 text-center">CIMB Niaga</label>

                <input id="bank06" type="radio" name="accountbank" value="OTHER">
                <label for="bank06" class="rounded-full px-4 py-3 text-center">Lainnya</label>
              </fieldset>
            </flux:field>
            <flux:error name="accountbank"/>
          </div>
          <div class="mb-6">
            <flux:input
                wire:model="accountno"
                label="Nomor Rekening*"
              />
          </div>
          <div class="mb-6">
            <flux:input
                wire:model="accountholder"
                label="Nama Pemilik Rekening*"
                placeholder="Harus sama dengan nama di rekening bank"
              />
          </div>          
          <div class="flex justify-between">
            <flux:button variant="ghost" icon="arrow-left" wire:click="back">Kembali</flux:button>
            <flux:button variant="ghost" icon:trailing="arrow-right" wire:click="next">Lanjutkan</flux:button>
          </div>
        </div>

        <!-- Form Steps -->
        <div class="form-step {{ $currentStep == 5 ? 'active' : '' }}">
          <h2 class="text-2xl font-bold mb-6">Persetujuan</h2>
          <div class="mb-6">
            <flux:field variant="inline" class="flex items-center">
              <flux:checkbox wire:model="agreement"/>
              <flux:label>Saya&nbsp;setuju&nbsp;dengan&nbsp;<a href="/#cara-kerja" class="text-blue-600 hover:underline">Syarat&nbsp;dan&nbsp;Ketentuan</a>&nbsp;serta&nbsp;<a href="/#mengapa" class="text-blue-600 hover:underline">Kebijakan Privasi</a>&nbsp;Bantoo!</span></flux:label>
            </flux:field>
            <flux:error name="agreement"/>
          </div>
          <div class="flex justify-between">
          <flux:button variant="ghost" icon="arrow-left" wire:click="back">Kembali</flux:button>
          <flux:button variant="primary" wire:click="next">Buat Penggalangan Dana</flux:button>
          </div>
        </div>

        <!-- Form Steps -->
        <div class="form-step {{ $currentStep > 5 ? 'active' : '' }}">
          <!-- Campaign Card 1 -->
          <div class="campaign-card rounded-lg overflow-hidden shadow-md transition duration-300">
            <div class="relative">
              <img src="/photos/{{ $campaign?->photo }}" alt="{{ $campaign?->category }} fundraiser" class="max-w-full max-h-48"/>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg mb-2">{{ $title }}</h3>
              <p class="text-gray-600 text-sm mb-4">{{ $description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <flux:modal name="success" :dismissible="false" wire:cancel="close" wire:close="close">
        <div class="rounded-xl p-8 max-w-md w-full mx-4">
          <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-500 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">Penggalangan Dana Berhasil Dibuat!</h3>
            <p class="text-gray-600 mb-6">Penggalangan dana Anda sedang dalam proses peninjauan. Kami akan mengirimkan email konfirmasi maksimal dalam tiga hari kerja.</p>
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Nomor Penggalangan</span>
                    <span class="font-medium">BTO-2023-987654</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="font-medium text-yellow-600">Dalam Peninjauan</span>
                </div>
            </div>
            <div class="flex justify-between">
              <flux:button variant="filled" wire:click="share"><i class="fab fa-facebook-f mr-2"></i> Bagikan</flux:button>
              <flux:button variant="filled" wire:click="preview">Lihat Pratinjau</flux:button>
            </div>
          </div>
        </div>
    </flux:modal>
  </div>
</div>