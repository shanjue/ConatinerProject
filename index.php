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
$container = new Container();

$container->bind('FullName', FullName::class);

$container->addFactory('Clo', function () {
    $param = 'Michael ';
    $func  = function () use (&$param) {
        $param .= 'Dave!';
    };
    $func();
    return 'I am ' . $param; // prints I am Dave!
});

echo $container->get('Clo')();
echo $container->get('FullName')->getFullName();
