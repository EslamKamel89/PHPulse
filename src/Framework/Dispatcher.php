<?php

declare(strict_types=1);

namespace Framework;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use ReflectionClass;
use ReflectionMethod;
use Framework\Request;

class Dispatcher {
    public function __construct(private Router $router, private Container $container) {
    }
    public function handle(Request $request) {
        $path = $this->getPath($request->uri);
        $params =  $this->router->match($path, $request->method);
        if (!$params) {
            throw new PageNotFoundException("No match found for {$path} with  {$request->method} method.");
        }
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);
        $cont = $this->container->get($controller);
        $cont->setRequest($request);
        $args =  $this->getActionArguments($controller, $action, $params);
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
    private function getPath(string $uri): string {
        $path = parse_url($uri, PHP_URL_PATH);
        if ($path === false) {
            throw new \UnexpectedValueException("Malformed URL: {$uri}");
        }
        return $path;
    }
}
