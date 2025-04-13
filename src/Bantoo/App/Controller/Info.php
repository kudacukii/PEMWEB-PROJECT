<?php

namespace Bantoo\App\Controller;

final class Info {
  public static function show(): void {
    phpinfo();
  }
}
