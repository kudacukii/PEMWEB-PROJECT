<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\UserCampaign;
use App\Livewire\Campaign\ShowCampaign;
use App\Livewire\Campaign\CreateCampaign;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ImageController;

Route::get('/', LandingPageController::class)->name('landing');

Route::get('/images/{path}', ImageController::class)
  ->where('path', '.*')
  ->name('image.show');

Route::middleware(['auth', 'verified'])->group(function () {
  Route::redirect('settings', 'settings/profile');

  Route::get('settings/profile', Profile::class)->name('settings.profile');
  Route::get('settings/password', Password::class)->name('settings.password');
  Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
  Route::get('settings/campaign', UserCampaign::class)->name('settings.campaign');

  Route::view('/home', 'home')->name('home');
  Route::get('/new', CreateCampaign::class)->name('campaign.create');
  Route::get('/show', ShowCampaign::class)->name('campaign.show');
});

require __DIR__.'/auth.php';
