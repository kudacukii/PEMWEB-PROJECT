<?php

use App\Http\Controllers\ImageController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/images/{path}', ImageController::class)
    ->where('path', '.*')
    ->name('image.show');

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::redirect('/settings', '/settings/profile');

    Route::get('/settings/profile', Profile::class)->name('settings.profile');
    Route::get('/settings/password', Password::class)->name('settings.password');
    Route::get('/settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
