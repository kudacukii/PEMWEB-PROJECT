<?php

namespace App\Utils;

final class Helper {
  public static function humanize($number): string
  {
    $divisor = match(true) {
      $number < 1_000_000         => 1_000,
      $number < 1_000_000_000     => 1_000_000,
      $number < 1_000_000_000_000 => 1_000_000_000,
    };

    $denom = match(true) {
      $divisor == 1_000 => "ribu",
      $divisor == 1_000_000 => "juta",
      $divisor == 1_000_000_000 => "milyar",
    };

    $num = (int)floor($number / $divisor);

    return match(true) {
      $num == 0   => "{$num}",
      $num < 1000 => "{$num} {$denom}",
    };
  }

}
