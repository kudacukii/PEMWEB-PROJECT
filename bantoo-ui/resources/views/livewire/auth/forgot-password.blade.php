<div class="flex flex-col gap-6">
  <x-auth-header title="Lupa Kata Sandi" />
  <x-auth-session-status class="text-center" :status="session('status')" />

  <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
    <flux:input
        wire:model="email"
        label="Alamat Email"
        type="email"
        required
        autofocus
        placeholder="email@example.com"
        viewable
    />
    <flux:button variant="primary" type="submit" class="w-full">Kirim Email Ganti Kata Sandi</flux:button>
  </form>

  <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
    Atau, kembali ke
    <flux:link :href="route('login')" wire:navigate>Masuk</flux:link>
  </div>
</div>
