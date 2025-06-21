<div>
  <ul>
  @foreach ($campaigns as $campaign)
    <li wire:key="campaign-{{ $campaign->id }}">
      <div class="flex flex-row items-between border border-zinc-600 dark:border-zinc-400 rounded-2xl mb-1 justify-between">
        <div class="rounded-xl ml-3 p-2 grow-0">
          <img src="/images/{{ $campaign->photo }}" class="rounded-2xl" width="200px"/>
        </div>
        <div class="grow-1 ml-1.5 p-2 flex flex-col items-stretch">
          <div>{{ $campaign->title }}</div>
          <div>{{ $campaign->description }}</div>
          <div>Target penggalangan {{ $campaign->targetfunding }}</div>
        </div>
        <div class="grow-0 mr-3 p-2 flex flex-col-reverse justify-items-start gap-1 min-w-30">
          @if ($campaign->status === 'PENDING')
          <flux:button wire:click="approve({{ $campaign->id }})">Setujui</flux:button>
          <flux:button wire:click="reject({{ $campaign->id }})">Tolak</flux:button>
          @endif
          @if ($campaign->status === 'SUSPEND')
          <flux:button wire:click="continue({{ $campaign->id }})">Lanjutkan</flux:button>
          <flux:button wire:click="terminate({{ $campaign->id }})">Hentikan</flux:button>
          @endif
          @if ($campaign->status === 'ACTIVE')
          <flux:button wire:click="terminate({{ $campaign->id }})">Hentikan</flux:button>
          <flux:button wire:click="complete({{ $campaign->id }})">Selesai</flux:button>
          <flux:button wire:click="suspend({{ $campaign->id }})">Tunda</flux:button>
          @endif
          <flux:button wire:click="viewDetail({{ $campaign->id }})">Info</flux:button>
        </div>
      </div>
    </li>
  @endforeach
  </ul>
</div>
