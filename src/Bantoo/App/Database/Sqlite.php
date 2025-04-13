<?php

namespace Bantoo\App\Database;

use \Bantoo\App\Utils\Log;

final class Sqlite {
  public static function getConnection(): ?\PDO {
    $sqlite_file = __DIR__ . '/../../../../database/test.db';
    try {
      $conn = new \PDO("sqlite:" . $sqlite_file);
      $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      return $conn;
    }
    catch (\PDOException $exception) {
      Log::exception($exception);
      return null;
    }
  }
}
