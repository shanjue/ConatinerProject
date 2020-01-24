<?php

use ContainerProject\Container;

require_once __DIR__ . '/vendor/autoload.php';

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

$container = new Container();

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

echo $container->get('RedCar')->build();
echo $container->get('Clo')();
echo $container->get('FullName')->getFullName();
