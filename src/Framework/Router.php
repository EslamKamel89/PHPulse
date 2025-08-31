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
    public function match(string $path, string $method): array | bool {
        $path = urldecode($path);
        // print_r(compact('path'));
        $path = trim($path, '/');
        foreach ($this->routes as $route) {
            $pattern =  $this->getPatternFromRoutePath($route['path']);
            // print_r(compact('pattern'));
            if (preg_match($pattern, $path, $matches)) {
                $matches =    array_filter($matches, function ($key,) {
                    return preg_match('#[a-z]+#', $key);
                }, ARRAY_FILTER_USE_KEY);
                $params = array_merge($matches, $route['params']);
                if (array_key_exists('method', $params)) {
                    if (strtolower($method) !== strtolower($params['method'])) {
                        continue;
                    }
                }
                return $params;
            }
        }
        return false;
    }
    private function getPatternFromRoutePath(string $routePath): string {
        $routePath = trim($routePath, '/');
        $segements = explode('/', $routePath);
        $segements = array_map(function ($segement,) {
            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segement, $matches)) {
                return  "(?<" . $matches[1] . ">[^/]*)";
            }
            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segement, $matches)) {
                return  "(?<" . $matches[1] . ">" . $matches[2] . ")";
            }
            return $segement;
        }, $segements);
        $segements = "#^" . implode('/', $segements,) . "$#iu";
        return $segements;
    }
}
