<?php

// Include simple file logger earlier to able write error
require_once __DIR__ . '/Bantoo/App/Utils/Log.php';

error_reporting(E_ALL);

function bantooExceptionHandler ($e): never {
  error_log($e);
  \Bantoo\App\Utils\Log::exception($e);

  http_response_code(500);
  if (filter_var(ini_get('display_errors'),FILTER_VALIDATE_BOOLEAN)) {
    echo $e;
  } else {
    echo<<<EOL
    <h1>500 Internal Server Error. Please check the logs for more information.</h1>
    An internal server error has been occurred.<br>
    Please try again later.
    EOL;
  }

  exit;
}

set_exception_handler('bantooExceptionHandler');

// Catch all unhandled exceptions
set_error_handler (function($errno, $errstr, $errfile, $errline): never {
  throw new ErrorException($errstr, $errno, 0, $errfile, $errline);     
});

register_shutdown_function(function (): void {
  $error = error_get_last();
  if ($error !== null) {
    $e = new ErrorException(
        $error['message'], 0, $error['type'], $error['file'], $error['line']
    );
    bantooExceptionHandler($e);
  }
});

require_once __DIR__ . '/Bantoo/App/Dependencies.php';

foreach (dependencies() as $inc) {
  if (file_exists($inc) && is_readable($inc)) {
    require_once $inc;
  }
  else {
    throw new Exception("Dependency file $inc does not exists or is not readable.");
  }
}
