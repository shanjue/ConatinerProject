<?php

namespace ContainerProject;

use Closure;
use ReflectionClass;
use ReflectionParameter;
use ContainerProject\ClassDefination;
use Psr\Container\ContainerInterface;
use ContainerProject\NotFoundException;

class Container implements ContainerInterface
{
    /**
     * Definations
     * @var array
     */
    private $definations = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException(sprintf('%s is not defined.', $id));
        }

        /**
         * highlight_string("<?php\n" . var_export($this->definations, true) . ";\n?>");
         *  */
        return $this->definations[$id]->build();
    }

    public function has($id)
    {
        return array_key_exists($id, $this->definations);
    }

    public function bind(string $alias, string $concrete)
    {
        $reflectionClass = new ReflectionClass($concrete);

        if ($this->has($alias)) {
            throw new ContainerException(\sprintf('Same Class %s is Found', $alias));
        }

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException(sprintf('%s is not instantiable', $alias));
        }

        $this->resolve($alias, $concrete);
    }
    public function bindClosure(string $alias, Closure $concrete)
    {
        if (!$concrete instanceof Closure) { // We use closures in order to enable factory composition
            throw new ContainerException(sprintf('%s is not closure', $concrete));
        }

        $this->definations[$alias] = new FactoryDefination($concrete);
    }

    public function bindSetter(string $alias, string $concrete, $method)
    {
        $this->definations[$alias] = new SetterDefination($concrete, $method);
    }

    public function resolve(string $alias, string $concrete)
    {
        $this->definations[$alias] = new ClassDefination($concrete);
    }

    public function bindSkeleton(string $alias, string $concrete)
    {
        $this->definations[$alias] = new SkeletonDefination($concrete);
    }
}
