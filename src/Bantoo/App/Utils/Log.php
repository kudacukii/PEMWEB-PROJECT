<?php

namespace Bantoo\App\Utils;

final class Log {
  public static function exception(\Throwable $throwable): void {
    $logFile = __DIR__ . '/../../../../logs/error_log.txt';
    $message = date('Y-m-d H:i:s') . ' - Error: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine() . PHP_EOL;
    file_put_contents($logFile, $message, FILE_APPEND);
  }

  public static function trace(string $message): void {
    $logFile = __DIR__ . '/../../../../logs/trace_log.txt';
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - Trace: ' . $message . PHP_EOL, FILE_APPEND);
  }
}
