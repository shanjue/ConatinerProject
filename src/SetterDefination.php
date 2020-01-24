<?php

namespace ContainerProject;

class SetterDefination implements DefinationInterface
{
    private $concrete;
    private $method;

    public function __construct(string $concrete, array $method)
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
        foreach ($method as $method => $parameter) {
            $instance->$method($parameter);
        }
        return $instance;
    }
}
