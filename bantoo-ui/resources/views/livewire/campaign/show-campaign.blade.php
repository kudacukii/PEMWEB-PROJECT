<div>
  <div>
    <div class="container mx-auto px-4">
      <div class="radio-pills">
        <input class="radio-pill" type="radio" name="category" id="p01" wire:click="changeCategoryTo('ALL')"        /><label for="p01">Semua</label>
        <input class="radio-pill" type="radio" name="category" id="p02" wire:click="changeCategoryTo('HEALTH')"     /><label for="p02">Kesehatan</label>
        <input class="radio-pill" type="radio" name="category" id="p03" wire:click="changeCategoryTo('EDUCATION')"  /><label for="p03">Pendidikan</label>
        <input class="radio-pill" type="radio" name="category" id="p04" wire:click="changeCategoryTo('EMERGENCY')"  /><label for="p04">Darurat</label>
        <input class="radio-pill" type="radio" name="category" id="p05" wire:click="changeCategoryTo('DISASTER')"   /><label for="p05">Bencana</label>
        <input class="radio-pill" type="radio" name="category" id="p06" wire:click="changeCategoryTo('PETS')"       /><label for="p06">Hewan Peliharaan</label>
        <input class="radio-pill" type="radio" name="category" id="p07" wire:click="changeCategoryTo('CREATIVITY')" /><label for="p07">Kreatif</label>
      </div>
    </div>
  </div>
  <div class="py-16">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">{{ $title }}</h2>
        <div class="flex items-center">
          <!-- <span>{{ $currentRows }}&nbsp;&nbsp;</span> -->
          <span class="mr-2 text-zinc-600 dark:text-zinc-400">Urutkan:</span>
          <select class="border border-zinc-300 bg-zinc-100 rounded-full px-3 py-1 dark:bg-zinc-400 dark:border-zinc-600">
            <option>Paling Baru</option>
            <option>Paling Populer</option>
            <option>Hampir Berakhir</option>
            <option>Paling Mendesak</option>
          </select>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-8">
        <ul class="grid grid-cols-1 gap-y-10 gap-x-6 items-start p-8">
        @foreach ($campaigns as $campaign)
          <li wire:key="campaign-{{ $campaign['id'] }}" class="flex flex-col items-start rounded-lg shadow-xl shadow-zinc-600 bg-zinc-100 dark:bg-zinc-800 border-zinc-400 dark:border-zinc-700">
            <div class="flex flex-row items-stretch w-full px-8 py-6">
              <img class="grow-0 border rounded-lg drop-shadow-lg" src="{{ $campaign['photo'] }}" alt="{{ $campaign['title'] }}" width="350px"/>
              <div class="grow-1 flex flex-col justify-between items-stretch ml-7">
                <div>
                  <div class="flex justify-between mb-1 text-2xl font-bold">
                    {{ $campaign['title'] }}
                    <div class="top-2 right-2 px-2 py-1 text-xs rounded-full bg-zinc-200 dark:bg-zinc-400 font-bold flex flex-row items-center">
                      @if($campaign['status'] === 'ACTIVE')
                      <flux:icon.heart variant="solid" class="text-red-500 size-4"/>&nbsp;{{ $campaign['likes'] }}
                      @endif
                      @if($campaign['status'] === 'PENDING')
                      <flux:icon.document-check variant="solid" class="text-yellow-500 size-4"/>&nbsp;Ditinjau
                      @endif
                      @if($campaign['status'] === 'COMPLETE')
                      <flux:icon.check variant="solid" class="text-green-500 size-4"/>&nbsp;Selesai
                      @endif
                      @if($campaign['status'] === 'TERMINATE')
                      <flux:icon.archive-box-x-mark variant="solid" class="text-red-500 size-4"/>&nbsp;Dihentikan
                      @endif
                    </div>
                  </div>
                  <div class="text-1xl font-normal">
                    <p>{{ $campaign['description'] }}</p>
                  </div>
                </div>
                <div class="mt-6">
                  <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium">Rp. {{ $campaign['amount'] }} terkumpul</span>
                    <span class="text-gray-500">dari Rp. {{ $campaign['target'] }}</span>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $campaign['percent'] }}%"></div>
                  </div>
                  <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ $campaign['donation'] }} donasi</span>
                    <span class="text-gray-600">{{ $campaign['dayleft'] }} hari lagi</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-row justify-between w-full px-8 py-6">
              @if (Auth::user()->id != $campaign['owner'])
              <flux:button wire:click.prevent="edit({{ $campaign['id'] }}, false)">Lebih Detail</flux:button>
              <flux:button variant="primary" icon="banknotes" wire:click.prevent="donate({{ $loop->index }})">Donasi sekarang</flux:button>
              @else
              <flux:button wire:click.prevent="edit({{ $campaign['id'] }}, true)">Edit</flux:button>
              @endif
            </div>
          </li>
        @endforeach
        </ul>
      </div>
      <div class="text-center mt-10">
        <button wire:click.prevent="loadMore" class="load-more">Lihat lebih banyak penggalangan dana</button>
      </div>
    </div>
  </div>
  <livewire:campaign.donate-campaign />
  <livewire:campaign.edit-campaign />
</div>