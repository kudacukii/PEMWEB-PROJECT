<div class="flex flex-col gap-6">
  <x-auth-header title="Verifikasi Email Anda" />
  <div class="bg-white rounded-lg auth-card p-8">
    <div class="mt-4 flex flex-col gap-6">
      <flux:text class="text-center">
        Silakan verifikasi alamat email dengan mengklik tautan yang baru saja dikirim ke email anda
      </flux:text>

      @if (session('status') == 'verification-link-sent')
      <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
        Tautan verifikasi sudah dikirim ke alamat email yang disebutkan saat registrasi.
      </flux:text>
      @endif

      <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full">
            Kirim ulang email verifikasi
        </flux:button>

        <flux:link class="text-sm cursor-pointer" wire:click="logout">
            Keluar
        </flux:link>
      </div>
    </div>
  </div>
</div>