<?php

namespace ContainerProject;

class SetterDefination implements DefinationInterface
{
    private $concrete;
    private $method;

    public function __construct(string $concrete, $method)
    {
        $this->concrete = $concrete;
        $this->method = $method;
    }

    public function build()
    {
        return $this->instantiate($this->concrete, $this->method);
    }

    public function instantiate($concrete, $method)
    {
        $instance = new $concrete;

        if(is_array($method)){
            foreach ($method as $methodname => $parameter) {
                $instance->$methodname($parameter);
            }
        }

        if(is_string($method)){
            $instance->$method();
        }
        
        return $instance;
    }
}
