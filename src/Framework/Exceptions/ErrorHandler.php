<?php

declare(strict_types=1);

namespace Framework\Exceptions;



class ErrorHandler {
    public static  function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ): bool {
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    public static function handleException(\Throwable $exception): void {
        if ($exception instanceof \Framework\Exceptions\PageNotFoundException) {
            http_response_code(404);
            $template = '404.php';
        } else {
            http_response_code(500);
            $template = '500.php';
        }
        $showErrors = $_ENV['SHOW_ERRORS'] === 'true';
        ini_set('log_errors', '1');
        if ($showErrors) {
            ini_set('display_errors', '1');
        } else {
            ini_set('display_errors', '0');
            require "views/$template";
        }
        throw $exception;
    }
}
