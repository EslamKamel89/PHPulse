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
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);
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
    private function getControllerName(array $params) {
        $controller = $params['controller'];
        $controller = ucwords(strtolower($controller), '-');
        $controller = str_replace('-', '', $controller);
        $namespace = 'App\Controllers';
        return $namespace . '\\' . $controller;
    }
    private function getActionName(array $params) {
        $action = $params['action'];
        $action = ucwords(strtolower($action), '-');
        $action = str_replace('-', '', $action);
        $action = lcfirst($action);
        return  $action;
    }
}
