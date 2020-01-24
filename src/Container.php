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
     * Definitions
     * @var array
     */
    private $definitions = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException(sprintf('%s is not defined.', $id));
        }

        /**
         * highlight_string("<?php\n" . var_export($this->definitions, true) . ";\n?>");
         *  */
        return $this->definitions[$id]->build();
    }

    public function has($id)
    {
        return array_key_exists($id, $this->definitions);
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

        $this->definitions[$alias] = new FactoryDefination($concrete);
    }

    public function bindSetter(string $alias, string $concrete, array $method)
    {
        $this->definitions[$alias] = new SetterDefination($concrete, $method);
    }

    public function resolve(string $alias, string $concrete)
    {
        $this->definitions[$alias] = new ClassDefination($concrete);
    }
}
