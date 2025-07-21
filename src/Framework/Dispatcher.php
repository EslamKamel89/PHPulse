<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher {
    public function __construct(private Router $router) {
    }
    public function handle(string $path) {
        $params =  $this->router->match($path);
        if (!$params) {
            exit('404 not found');
        }
        $action = $params['action'];
        $controller = 'App\Controllers\\' . ucwords($params['controller']);
        $args =  $this->getActionArguments($controller, $action, $params);
        $cont = new $controller();
        $cont->$action(...$args);
    }
    private function getActionArguments(string $controller, string $action, array $params): array {
        $args = [];
        $method = new ReflectionMethod($controller, $action);
        $paramaters =   $method->getParameters();
        foreach ($paramaters as $paramater) {
            $name = $paramater->getName();
            $args[$name]  =  $params[$name];
        }
        return $args;
    }
}
