<?php

namespace Framework;

class Container {
    private array $registry = [];
    public function set(string $name, \Closure $value): void {
        $this->registry[$name] =  $value;
    }
    public function get(string $className): object {
        if (array_key_exists($className, $this->registry)) {
            return $this->registry[$className]();
        }
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
