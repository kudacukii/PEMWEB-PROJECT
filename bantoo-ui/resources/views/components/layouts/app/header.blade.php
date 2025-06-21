<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('partials.head')
  </head>
  <body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 shadow-sm sticky top-0 z-50">
      <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
        <x-app-logo />
      </a>
        
      <flux:navbar class="me-1.5 space-x-0.5">
        <flux:navbar.item href="{{ route('campaign.show') }}">Untuk Individu</flux:navbar.item>

        <flux:dropdown class="max-lg:hidden">
          <flux:navbar.item icon:trailing="chevron-down">Untuk Organisasi</flux:navbar.item>
          <flux:navmenu>
            <flux:navmenu.item href="{{ route('home') }}/#">Mulai penggalangan dana</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('home') }}/#">Sumber daya organisasi</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('home') }}/#">Kisah sukses</flux:navmenu.item>
          </flux:navmenu>
        </flux:dropdown>

        <flux:navbar.item href="{{ route('home') }}/#cara-kerja">Cara kerjanya</flux:navbar.item>
      </flux:navbar>

      <flux:spacer />

      <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
        <flux:tooltip content="Cari" position="bottom">
          <flux:navbar.item icon="magnifying-glass" href="#" label="Cari" />
        </flux:tooltip>
        @guest
        <flux:navbar.item href="{{ route('login') }}">Masuk</flux:navbar.item>
          @if (Route::has('register'))
          <flux:navbar.item href="{{ route('register') }}">Daftar</flux:navbar.item>
          @endif
        @else
        <flux:dropdown>
          <flux:profile class="cursor-pointer" name="{{ auth()->user()->name }}" />
          <flux:navmenu>
            <flux:navmenu.item href="{{ route('settings.profile') }}" icon="cog" wire:navigate>Pengaturan</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('campaign.create') }}" icon="banknotes" wire:navigate>Mulai penggalangan dana</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('settings.campaign') }}" icon="document-currency-dollar" wire:navigate>Daftar Penggalangan Dana</flux:navmenu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
              @csrf
              <flux:navmenu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">Keluar</flux:navmenu.item>
            </form>
          </flux:navmenu>
        </flux:dropdown>
        @endguest
      </flux:navbar>
    </flux:header>
    <main>
    {{ $slot }}
    </main>
    @include('partials.footer') 

    @fluxScripts
  </body>
</html>
