<?php

namespace Framework;

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
        $cont = new $controller();
        $cont->$action();
    }
}
