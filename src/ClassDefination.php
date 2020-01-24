<?php

namespace ContainerProject;

use ReflectionClass;
use ReflectionParameter;

class ClassDefination implements DefinationInterface
{
    private $concrete;

    public function __construct($concrete)
    {
        $this->concrete = $concrete;
    }

    public function build()
    {
        return $this->instantiate($this->concrete);
    }

    public function getReflector(string $concrete)
    {
        $reflectionClass = new ReflectionClass($concrete);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException(sprintf('%s is not instantiable', $concrete));
        }
        return $reflectionClass;
    }

    public function instantiate(string $concrete)
    {
        $reflectionClass = $this->getReflector($concrete);

        $constructor = $reflectionClass->getConstructor();

        if (!is_null($constructor)) {
            $parameters = $constructor->getParameters();
        }

        if (is_null($constructor) || empty($parameters)) {
            return $reflectionClass->newInstance();
        }

        foreach ($parameters as $parameter) {
            $resolved[] = $this->resolveParameters($parameter);
        }
        
        return $reflectionClass->newInstanceArgs($resolved);
    }


    public function resolveParameters(ReflectionParameter $parameter)
    {
        $className = $parameter->getClass()->name;
        
        $instance = $this->instantiate($className);

        return $instance;
    }
}
