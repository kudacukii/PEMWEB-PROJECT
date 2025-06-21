<div class="grid grid-cols-3 gap-8">
  @foreach ($campaigns as $campaign)
  <div wire:key="{{ $campaign['id'] }}"> 
    <div class="campaign-card">
      <div class="relative">
        <img src="{{ $campaign['photo'] }}" alt="{{ $campaign['title'] }}" class="w-full h-48 object-cover">
        <div class="absolute top-2 right-2 bg-zinc-400 rounded-full px-2 py-1 text-xs font-bold flex items-start">
          <flux:icon.heart variant="solid" class="text-red-500 size-4"/>&nbsp;{{ $campaign['likes'] }}
        </div>
      </div>
      <div class="p-6">
        <h3 class="font-bold text-lg mb-2">{{ $campaign['title'] }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ $campaign['description'] }}</p>
        <div class="mb-4">
          <div class="flex justify-between text-sm mb-1">
            <span class="font-medium">Rp. {{ $campaign['amount'] }} terkumpul</span>
            <span class="text-gray-500">dari Rp. {{ $campaign['target'] }}</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $campaign['percent'] }}%"></div>
          </div>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-600">{{ $campaign['donation'] }} donasi</span>
          <span class="text-gray-600">{{ $campaign['dayleft'] }} hari lagi</span>
        </div>
        <div class="flex justify-center items-center">
          <flux:button variant="primary" icon="banknotes" wire:click="donate({{ $loop->index }})">Donasi sekarang</flux:button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <livewire:campaign.donate-campaign />
</div>
