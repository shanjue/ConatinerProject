<?php

namespace ContainerProject;

use ContainerProject\DefinationInterface;

class SkeletonDefination implements DefinationInterface
{
    protected $concrete;

    public function __construct(string $concrete)
    {
        $this->concrete = $concrete;    
    }
    public function build()
    {
        return $this->concrete;
    }
}