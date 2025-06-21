<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  public function __invoke(Request $request, $filepath)
  {
    $path = Storage::disk('photos')->path($filepath);

    abort_unless(File::exists($path), 404);

    return response(File::get($path), 200)
    ->header('Content-Type', File::mimeType($path))
    ->header('Cache-Control', 'public, max-age=2592000, s-maxage=2592000, immutable');
  }
}
