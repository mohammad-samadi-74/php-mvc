<?php

namespace App\Core\library;

abstract class ServiceProvider
{
    public object|null $app;
    public array $bootServices = [];
    public array $registerServices = [];

    public function __construct($appObject)
    {
        $this->app = $appObject;
    }


    public function register()
    {

    }

    public function boot()
    {
        //boot
    }


    public function addService($class)
    {
        $this->app->addService([(new \ReflectionClass($class))->getShortName() => $class]);
    }
}