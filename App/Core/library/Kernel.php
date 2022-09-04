<?php

namespace App\Core\library;

class Kernel
{

    private static $app;

    protected array $container = [];

    public array $services = [];

    public static function registered(): bool
    {
        return is_object(self::$app);
    }

    public static function getApp()
    {
        return self::$app;
    }

    public function getService($name)
    {
        if ($this->hasService($name)) {
            if ($this->hasServiceInContainer($name)) {
                return $this->container[$name];
            } else {
                return $this->container[$name] = new ($this->services[$name])();
            }
        }
        throw_exception("service $name doesnt exists in services in" . __FILE__);
    }

    public function hasService($name): bool
    {
        return isset($this->services[$name]);
    }

    private function hasServiceInContainer($name): bool
    {
        return isset($this->container[$name]);
    }

    public function saveApp(): static
    {
        self::$app = $this;

        $this->runProvidersRegister();
        $this->runProvidersBoot();

        return $this;
    }

    protected function runProvidersBoot()
    {
        foreach ($this->providers as $provider) {
            $obj = (new $provider($this));
            $obj->boot();
        }
    }

    protected function runProvidersRegister()
    {
        foreach ($this->providers as $provider) {
            $obj = (new $provider($this));
            $obj->register();
        }
    }

    public function addService(array $class)
    {
        $this->services[array_key_first($class)] = $class[array_key_first($class)];
    }
}