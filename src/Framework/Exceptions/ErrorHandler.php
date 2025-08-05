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
}
