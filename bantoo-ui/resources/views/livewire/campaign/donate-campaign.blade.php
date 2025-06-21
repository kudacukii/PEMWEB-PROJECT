<div>
  <flux:modal name="donate-campaign" :dismissible="false" wire:cancel="close" wire:cancel="closeAll" wire:model.self="showDonateCampaignDialog">
    <div class="p-6">
      <div class=" mb-4 flex justify-between items-center">
        <h3 class="text-xl font-bold">{{ $campaign['title'] }}</h3>
      </div>
      <div class="mb-6 {{ $donationtype == "CHOOSE" ? 'show' : 'hide'}}">
        <h4 class="font-bold mb-2">Pilih Jenis Donasi</h4>
        <flux:radio.group variant="segmented" wire:model.change="donationtype">
          <flux:radio value="GOODS" label="Berupa Barang" icon="building-office-2"/>
          <flux:radio value="FUND"  label="Berupa Dana"   icon="wallet"/>
        </flux:radio.group>
      </div>
      <div class="{{ $donationtype == "GOODS" ? 'show' : 'hide'}}">
        <div class="mb-6">
          <h4 class="font-bold mb-2">Alamat Pengambilan Barang</h4>
          <flux:textarea
            placeholder="Jalan, No Bangunan, RT/RW, Desa, Kecamatan, Kota, Propinsi, Kode Pos"
            description="Tulis alamat pengambilan donasi barang dengan lengkap dan jelas untuk kemudahan pengambilan"
            wire:model="senderaddress"
          />
        </div>
        <div class="mb-6">
          <h4 class="font-bold mb-2">Nama Barang</h4>
          <flux:textarea
            placeholder="Beras 5kg, Migor 2L"
            description="Cantumkan nama atau jenis barang"
            wire:model="goodsname"
          />
        </div>
        <div class="mb-6">
          <h4 class="font-bold mb-2">Jumlah Barang</h4>
          <flux:textarea
            placeholder="Beras 10 karung @5Kg"
            description="Cantumkan kuantitas barang"
            wire:model="quantity"
          />
        </div>
        <div class="mb-6">
          <h4 class="font-bold mb-2">Foto Barang Yang Dikirim</h4>
          <div class="image-upload">
            <input
              id="photo"
              type="file"
              accept="image/*"
              wire:model="photo"
            />
            <label for="photo">
              @if (!$photo)
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                <p class="font-medium">Unggah foto barang yang dikirim</p>
                <p class="text-sm text-gray-500">Format JPG, PNG (maks. 5MB)</p>
                <p class="text-sm text-blue-500 mt-2">Pilih dari komputer</p>
                @else
                <img src="{{ $photo->temporaryUrl() }}">
              @endif
              <flux:error name="photo"/>
            </label>
          </div>
        </div>
        <div class="flex justify-center items-center">
          <flux:button variant="primary" wire:click="sendDonation">Kirim Donasi</flux:button>
        </div>
      </div>
      <div class="{{ $donationtype == "FUND" ? 'show' : 'hide'}}">
        <div class="mb-6">
          <div class="mb-1 flex justify-between text-sm">
            <span class="font-medium">Rp. {{ $campaign['amount'] }} terkumpul</span>
            <span class="text-gray-500">dari Rp. {{ $campaign['target'] }}</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $campaign['percent'] }}%"></div>
          </div>
        </div>
        <div class="mb-6">
          <h4 class="font-bold mb-2">Pilih Besaran Donasi</h4>
          <fieldset class="radio-cards grid-cols-3 gap-3 mb-4">
            <input  id="op01" value="100000" name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op01">Rp. 100.000</label>
            <input  id="op02" value="250000" name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op02">Rp. 250.000</label>
            <input  id="op03" value="500000" name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op03">Rp. 500.000</label>
            <input  id="op04" value="750000" name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op04">Rp. 750.000</label>
            <input  id="op05"value="1000000" name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op05">Rp. 1.000.000</label>
            <input  id="op06" value=""       name="paymentamount" wire:model="paymentamount" type="radio" class="radio-card"/>
            <label for="op06">Lainnya</label>
          </fieldset>
          <flux:field>
            <flux:label>Jumlah Donasi</flux:label>
            <livewire:campaign.money-input wire:model="paymentamount" name="paymentamount" id="paymentammount" placeholder="Contoh: Rp. 12.000.000,00"/>
            <flux:description>Tentukan sendiri besaran donasi anda</flux:description>
            <flux:error name="paymentamount" />
          </flux:field>
        </div>
        <div class="mb-6">
          <h4 class="font-bold mb-2">Metode pembayaran</h4>
          <fieldset class="radio-tabs">
            <input  id="bank" type="radio" name="paymentmethod" class="radio-tab" wire:model="paymentmethod" value="BANK"/>
            <label for="bank"><div class="flex flex-row"><flux:icon.building-office-2 varian="mini"/>&nbsp;Bank</div></label>
            <div class="tab-content radio-cards">
              <input  id="bca" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="BCA"/>
              <label for="bca">
                <div class="flex items-center">
                  <img src="/images/icons/bca.svg" alt="BCA" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">Bank Central Asia (BCA)</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Transfer Virtual Account</p>
                  </div>
                </div>
              </label>
              <input  id="mdr" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="MANDIRI"/>
              <label for="mdr">
                <div class="flex items-center">
                  <img src="/images/icons/mandiri.svg" alt="Mandiri" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">Bank Mandiri</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Transfer Virtual Account</p>
                  </div>
                </div>
              </label>
              <input  id="bri" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="BRI"/>
              <label for="bri">
                  <div class="flex items-center">
                    <img src="/images/icons/bri.svg" alt="BRI" class="w-10 h-10 mr-3">
                    <div>
                      <p class="font-medium">Bank Rakyat Indonesia (BRI)</p>
                      <p class="text-sm text-gray-500 dark:text-gray-400">Transfer Virtual Account</p>
                    </div>
                  </div>
              </label>
            </div>
            <input  id="wall" type="radio" name="paymentmethod" class="radio-tab" wire:model="paymentmethod" value="WALLET"/>
            <label for="wall"><div class="flex flex-row"><flux:icon.wallet varian="mini"/>&nbsp;E-Wallet</div></label>
            <div class="tab-content radio-cards">
              <input  id="ovo" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="OVO"/>
              <label for="ovo">
                <div class="flex items-center">
                  <img src="/images/icons/ovo.svg" alt="OVO" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">OVO</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dompet Digital</p>
                  </div>
                </div>
              </label>
              <input  id="dan" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="DANA"/>
              <label for="dan">
                <div class="flex items-center">
                  <img src="/images/icons/dana.svg" alt="DANA" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">DANA</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dompet Digital</p>
                  </div>
                </div>
              </label>
              <input  id="lkj" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="LINKAJA"/>
              <label for="lkj">
                <div class="flex items-center">
                  <img src="/images/icons/linkaja.svg" alt="LinkAja" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">LinkAja</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dompet Digital</p>
                  </div>
                </div>
              </label>
            </div>
            <input  id="card" type="radio" name="paymentmethod" class="radio-tab" wire:model="paymentmethod" value="CARD">
            <label for="card"><div class="flex flex-row"><flux:icon.credit-card varian="mini"/>&nbsp;Kartu Kredit</div></label>
            <div class="tab-content radio-cards">
              <input  id="vsa" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="VISA"/>
              <label for="vsa">
                <div class="flex items-center">
                  <img src="/images/icons/visa.svg" alt="Visa" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">Visa</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kartu Kredit</p>
                  </div>
                </div>
              </label>
              <input  id="mas" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="MASTERCARD"/>
              <label for="mas">
                <div class="flex items-center">
                  <img src="/images/icons/mastercard.svg" alt="Mastercard" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">Mastercard</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kartu Kredit</p>
                  </div>
                </div>
              </label>
              <input  id="jcb" type="radio" name="paymentchannel" class="radio-card" wire:model="paymentchannel" value="JCB"/>
              <label for="jcb">
                <div class="flex items-center">
                  <img src="/images/icons/jcb.svg" alt="JCB" class="w-10 h-10 mr-3">
                  <div>
                    <p class="font-medium">JCB</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kartu Kredit</p>
                  </div>
                </div>
              </label>
            </div>
          </fieldset>
          <flux:error name="paymentmethod"/>
          <flux:error name="paymentchannel"/>
        </div>
        <div class="mb-4">
          <flux:field variant="inline" class="flex items-center">
            <flux:checkbox wire:model="paymentanonim"/>
            <flux:label>Sembunyikan nama saya dari daftar donatur (donasi anonim)</flux:label>
          </flux:field>
        </div>
        <div class="flex justify-center items-center">
          <flux:button variant="primary" wire:click="makePayment">Lanjutkan Pembayaran</flux:button>
        </div>
      </div>
    </div>
  </flux:modal>
  <flux:modal name="donate-campaign-success" wire:cancel="closeAll" wire:cancel="closeAll" wire:model.self="showDonationSuccessDialog">
    <div class="p-6 text-center">
      <div class="mb-6">
        <flux:icon.check-circle class="text-green-500 size-20 flex items-center justify-center mx-auto mb-4"/>
        <h3 class="text-xl font-bold mb-2">{{ $donationtype == "FUND" ? 'Pembayaran Berhasil!' : 'Pengiriman Barang Tercatat!'}}</h3>
        <p class="text-base">{{ $campaign['donatur'] }}, terima kasih atas donasi Anda untuk {{ $campaign['title'] }}.</p>
      </div>
      <div class="{{ $donationtype == "GOODS" ? 'show' : 'hide'}}">
        <div class="grid grid-cols-1 bg-gray-50 rounded-lg p-4 mb-6">
          <div class="text-start mb-6">
            <h4 class="font-bold mb-2">Alamat Pengambilan Barang</h4>
            <div class="whitespace-pre-wrap">{{ $senderaddress }}</div>
          </div>
          <div class="text-start mb-6">
            <h4 class="font-bold mb-2">Nama Barang</h4>
            <div class="whitespace-pre-wrap">{{ $goodsname }}</div>
          </div>
          <div class="text-start mb-6">
            <h4 class="font-bold mb-2">Jumlah Barang</h4>
            <div class="whitespace-pre-wrap">{{ $quantity }}</div>
          </div>
          <div class="mb-2">
            <img src="/images/{{ $campaign['donationphoto'] }}" alt="Donasi barang {{ $campaign['donatur'] }}" class="max-w-full max-h-48 rounded-lg">
          </div>
        </div>
        <p class="text-sm text-gray-500 mb-6">Kami akan mengirimkan jadwal pengambilan barang ke email Anda di {{ $campaign['email'] }}. Silakan cek inbox atau folder spam jika tidak ditemukan.</p>
      </div>
      <div class="{{ $donationtype == "FUND" ? 'show' : 'hide'}}">
        <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 mb-6 text-left">
          <div class="flex justify-between mb-2">
            <span class="font-medium">Jumlah Donasi</span>
            <span class="font-medium">Rp. {{ $paymentamount }}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span class="font-medium">Metode Pembayaran</span>
            <span class="font-medium">Bank Central Asia (BCA)</span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium">Kode Transaksi</span>
            <span class="font-medium">BTO-2023-987654</span>
          </div>
        </div>
        <p class="text-sm mb-6">Kami telah mengirimkan bukti pembayaran ke email Anda di {{ $campaign['email'] }}. Silakan cek inbox atau folder spam jika tidak ditemukan.</p>
      </div>
      <div class="flex items-center justify-center">
        <flux:button variant="filled" wire:click="closeAll"><i class="fab fa-facebook-f mr-2"></i>&nbsp;Bagikan</flux:button>
      </div>
    </div>
  </flux:modal>
</div>
