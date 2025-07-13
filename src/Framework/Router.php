<?php

namespace Framework;

class Router {
    private array $routes = [];
    public function add(string $path, array $params): void {
        $this->routes[] = [
            'path' => $path,
            'params' => $params,
        ];
    }
    public function match(string $path): array | bool {
        $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";
        if (preg_match($pattern, $path, $matches)) {
            $matches =    array_filter($matches, function ($key,) {
                return preg_match('#[a-z]+#', $key);
            }, ARRAY_FILTER_USE_KEY);
            return $matches;
        }
        // foreach ($this->routes as $route) {
        //     if ($route['path'] == $path) {
        //         return $route['params'];
        //     }
        // }
        return false;
    }
}
