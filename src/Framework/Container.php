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
            $type = $parameter->getType();
            if ($type === null) {
                exit("Constructor parameter {$parameter->getName()} in the {$className} has no type decleration");
            }
            if (!$type instanceof \ReflectionNamedType) {
                exit("Constructor parameter {$parameter->getName()} in the {$className} has invalid type decleration");
            }
            if ($type->isBuiltin()) {
                exit("Unable to resolve the contructor pramater {$parameter->getName()} of type {$parameter->getType()} in the {$className} class");
            }
            $dependecies[] = $this->get($type);
        }
        return  new $className(...$dependecies);
    }
}
