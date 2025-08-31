<?php

declare(strict_types=1);

namespace Framework;

class Request {
    public function __construct(
        public string $uri,
        public string $method,
    ) {
    }
}
