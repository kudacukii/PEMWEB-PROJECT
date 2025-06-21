<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LandingPageController extends Controller
{
  /**
   * Redirect to /home if authenticated
   * @return void
   */
  public function __invoke(): RedirectResponse|View
  {  
    if (Auth::check()) {
      redirect()->route('home');
    }

    return view(view: 'home');
  }
}
