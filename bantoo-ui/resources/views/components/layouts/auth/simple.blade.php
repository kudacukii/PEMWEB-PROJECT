<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('partials.head')
  </head>
  <body class="flex flex-col justify-between min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 shadow-sm sticky top-0 z-50">
      <a href="/" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
        <x-app-logo />
      </a>
      <flux:navbar class="me-1.5 space-x-0.5">
        <flux:navbar.item href="{{ route('landing') }}" icon="home">Beranda</flux:navbar.item>
      </flux:navbar>
    </flux:header>
    <main class="mt-6">
      <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
        {{ $slot }}
        </div>
      </div>
    </main>
    @include('partials.footer') 
    @fluxScripts
  </body>
</html>
