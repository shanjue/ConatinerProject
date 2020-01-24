<?php

namespace ContainerProject;

use Closure;

class FactoryDefination implements DefinationInterface
{
    protected $concrete;

    public function __construct(Closure $concrete)
    {
        $this->concrete = $concrete;
    }

    public function build()
    {
        return $this->concrete;
    }

    public function instantiate($concrete)
    {
        //
    }
}