<?php

use ContainerProject\Container;

require_once __DIR__ . '/vendor/autoload.php';
class A
{
    public function __construct(B $b)
    {
        $this->b = $b;
    }
    public function bio()
    {
        return $this->b->bio();
    }
}
class B
{
    public function __construct(C $c)
    {
        $this->c = $c;
    }
    public function bio()
    {
        return $this->c->bio();
    }
}
class C
{
    public function bio()
    {
        return 'Bio from C Class';
    }
}
class FirstName
{
    public function getFirstName()
    {
        return 'MG SAI';
    }
}

class LastName
{
    public function getLastName()
    {
        return 'MYO MIN AUNG';
    }
}

class FullName
{
    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
    public function getFullName()
    {
        return $this->firstName->getFirstName() . ' ' . $this->lastName->getLastName();
    }
}

class RedCar
{
    public function info()
    {
        return 'Red Car Info';
    }
}
class CarFactory
{
    private $car;

    public function setCar($parameter)
    {
        if ($parameter == 'red') {
            $this->car = new RedCar;
        }
    }
    public function build()
    {
        return $this->car->info();
    }
}

class Coffee
{
    private static $coffee = 'Shwe Pa Zon Coffee';
    private static $milk = 'Pure Milk';

    public static function brew()
    {
        return 'You can brew ' . self::$coffee . ' with ' . self::$milk . '.';
    }
}

// echo Coffee::brew();
$container = new Container();
$container->bind('A', A::class);
$container->bindSetter('RedCar', CarFactory::class, ['setCar' => 'red']);

$container->bind('FullName', FullName::class);

$container->bindClosure('Clo', function () {
    $param = 'Michael ';
    $func  = function () use (&$param) {
        $param .= 'Dave!';
    };
    $func();
    return 'I am ' . $param; // prints I am Dave!
});

$container->bindSkeleton('coffee', Coffee::class);

echo $container->get('RedCar')->build();
echo $container->get('Clo')();
echo $container->get('FullName')->getFullName();
echo $container->get('coffee')::brew();
echo $container->get('A')->bio();
