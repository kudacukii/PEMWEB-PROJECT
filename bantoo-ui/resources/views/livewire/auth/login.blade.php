<div class="flex flex-col gap-6">
  <x-auth-header title="Masuk ke Bantoo!" />
  <x-auth-session-status class="text-center" :status="session('status')" />
  <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg auth-card p-8">      
    <div class="mb-3">
      <button class="social-btn w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-lg mb-3 hover:bg-gray-50">
        <i class="fab fa-google text-blue-600 text-lg mr-3"></i>
      <span>Lanjutkan dengan Google</span>
      </button>
      <button class="social-btn w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-lg mb-3 hover:bg-gray-50">
          <i class="fab fa-facebook text-blue-600 text-lg mr-3"></i>
          <span>Lanjutkan dengan Facebook</span>
      </button>
    </div>      
    <div class="flex items-center my-6">
      <div class="flex-grow border-t border-gray-300"></div>
      <span class="mx-4 text-gray-500">atau</span>
      <div class="flex-grow border-t border-gray-300"></div>
    </div>
    <form wire:submit="login" class="flex flex-col gap-6">
      <flux:input
          wire:model="email"
          label="Alamat email"
          type="email"
          required
          autofocus
          autocomplete="email"
          placeholder="email@example.com"
      />
      <div class="relative">
        <flux:input
            wire:model="password"
            label="Kata Sandi"
            type="password"
            required
            autocomplete="current-password"
            placeholder="Psst sangat rahasia..."
            viewable
        />
        @if (Route::has('password.request'))
        <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>Lupa kata sandi?</flux:link>
        @endif
      </div>
      <!-- Remember Me -->
      <flux:checkbox wire:model="remember" label="Ingat saya" />
      <div class="flex items-center justify-end">
        <flux:button variant="primary" type="submit" class="w-full">Masuk</flux:button>
      </div>
    </form>

    @if (Route::has('register'))
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
      Belum punya akun?
      <flux:link :href="route('register')" wire:navigate>Daftar sekarang</flux:link>
    </div>
    @endif
  </div>
</div>
