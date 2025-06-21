<div class="flex flex-col gap-6">
  <x-auth-header title="Buat Akun Baru" />
  <x-auth-session-status class="text-center" :status="session('status')" />
  <div class="bg-white rounded-lg auth-card p-8">
    <form wire:submit="register" class="flex flex-col gap-6">
      <flux:input
        wire:model="name"
        label="Nama"
        type="text"
        required
        autofocus
        autocomplete="name"
        placeholder="Nama Lengkap"
      />
      <flux:input
        wire:model="email"
        label="Alamat Email"
        type="email"
        required
        autocomplete="email"
        placeholder="email@example.com"
      />
      <flux:input
        wire:model="password"
        label="Kata Sandi"
        type="password"
        required
        autocomplete="new-password"
        placeholder="Psst sangat rahasia..."
        viewable
      />
      <!-- Confirm Password -->
      <flux:input
        wire:model="password_confirmation"
        label="Ulang Kata Sandi"
        type="password"
        required
        autocomplete="new-password"
        viewable
      />

      <div class="flex items-center justify-end">
        <flux:button type="submit" variant="primary" class="w-full">Buat Akun</flux:button>
      </div>
    </form>
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
    </div>
</div>
