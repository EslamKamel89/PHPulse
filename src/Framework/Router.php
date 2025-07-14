<?php

namespace Framework;

class Router {
    private array $routes = [];
    public function add(string $path, array $params = []): void {
        $this->routes[] = [
            'path' => $path,
            'params' => $params,
        ];
    }
    public function match(string $path): array | bool {
        $path = trim($path, '/');
        foreach ($this->routes as $route) {
            // $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";
            // print_r(compact('route', "pattern"));
            // print_r([$route['path'], $pattern]);
            $pattern =  $this->getPatternFromRoutePath($route['path']);
            if (preg_match($pattern, $path, $matches)) {
                $matches =    array_filter($matches, function ($key,) {
                    return preg_match('#[a-z]+#', $key);
                }, ARRAY_FILTER_USE_KEY);
                return $matches;
            }
        }
        return false;
    }
    private function getPatternFromRoutePath(string $routePath): string {
        $routePath = trim($routePath, '/');
        $segements = explode('/', $routePath);
        $segements = array_map(function ($segement,) {
            preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segement, $matches);
            $segement = "(?<" . $matches[1] . ">[a-z]+)";
            return $segement;
        }, $segements);
        $segements = "#^" . implode('/', $segements,) . "$#";
        // print_r(compact('segements'));
        return $segements;
    }
}
