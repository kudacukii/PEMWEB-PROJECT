<?php

namespace Bantoo\App\Utils;

final class Http {
  public static function redirect_to($url): void {
    header ("HX-Redirect: $url");
  }
}