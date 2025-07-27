<?php

namespace Framework;

class Container {
    public function get(string $className): object {
        $reflector  = new \ReflectionClass($className);
        $constructor = $reflector->getConstructor();
        $dependecies = [];
        if ($constructor === null) {
            return new $className();
        }
        foreach ($constructor->getParameters() as $parameter) {
            $type = (string)$parameter->getType();
            $dependecies[] = $this->get($type);
        }
        return  new $className(...$dependecies);
    }
}
