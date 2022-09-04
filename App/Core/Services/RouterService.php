<?php

namespace App\Core\Services;

use App\Core\Facades\Session;
use App\kernel;
use Exception;

class RouterService
{

    protected array $routes = [];
    protected array $currentRoute = [];
    public array $matches = [];


    public function get(string $address, array|string $action): static
    {
        $this->addRoute($address, $action);
        return $this;
    }

    public function post(string $address, array|string $action): static
    {
        $this->addRoute($address, $action, 'POST');
        return $this;
    }

    private function addRoute(string $address, array|string $action, string $method = 'GET')
    {
        $url = $address = preg_replace('/^\//', '', $address);
        $address = preg_replace('/\//', '\/', $address);
        $address = preg_replace('/\{([a-z0-9A-Z-]+)\}/', '(?<\1>[0-9a-zA-Z-]+)', $address);
        $address = '/^' . $address . '$/';

        if (is_string($action)) {
            $action = explode('@', $action);
        }

        $this->routes[$address] = ['url'=>$url , 'method' => strtoupper($method), 'controller' => $action[0], 'action' => $action[1]];

    }

    public function dispatch(): bool
    {
        Session::reduceFlash();
        $this->saveQueryString();
        $currentAddress = preg_replace('/^\//', '', $_SERVER['PATH_INFO'] ?? "");
        $currentAddress = preg_replace('/\/$/', '', $currentAddress);

        return $this->match($currentAddress);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function saveQueryString()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $props = explode('&', htmlspecialchars($_SERVER['QUERY_STRING']));
            $props = array_filter($props, function ($prop) {
                return preg_match('/^[a-z_]+=[a-z0-9]+/', $prop);
            });

            array_map(function($prop) use ($props){
                list($key,$value) = explode('=',$prop);
                $props[$key] = $value;
            },$props);

        }
    }

    private function match($currentAddress): bool
    {

        foreach ($this->getRoutes() as $address => $action) {
            if (preg_match($address, $currentAddress, $matches)) {
                if ($action['method'] == $_SERVER['REQUEST_METHOD']) {

                    $this->currentRoute = $action;
                    $this->matches = $matches;

                    #save last route for redirect back
                    $lastRouteAddress = isset($_SERVER['QUERY_STRING']) ? $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'] ;
                    $lastRouteMethod = $_SERVER['REQUEST_METHOD'] ;

                    $_SESSION['route']['back'] = $_SESSION['route']['current'] ?? [];
                    $_SESSION['route']['current'] = ['address'=>$lastRouteAddress , 'method'=>$lastRouteMethod];

                    return true;
                }
            }
        }

        return false;
    }

    public function name($name){
        $this->routes[$this->findRouteKey()]['name'] = $name;
    }

    public function nameSpace($nameSpace){
        $this->routes[$this->findRouteKey()]['nameSpace'] = $nameSpace;
    }

    public function findRouteKey(): string|int
    {
        return array_keys($this->routes)[count(array_keys($this->routes)) - 1];
    }

    public function getCurrentRoute(): array
    {
        return $this->currentRoute;
    }

    public function runMethod()
    {

        $currentRoute = $this->getCurrentRoute();
        $this->checkMiddlewares($currentRoute);

        if(!isset($currentRoute['controller']) || !isset($currentRoute['action']))
            throw_exception('cant find this controller !');

        $controller = isset($currentRoute['nameSpace']) ? $currentRoute['nameSpace'].$currentRoute['controller'] : $currentRoute['controller'];

        $controller = !str_starts_with($controller,'App\Controllers\\') ? 'App\Controllers\\'.$controller : $controller;
        $method = trim($currentRoute['action']);

        if (!class_exists($controller)){
            throw_exception('cant find this controller !');
        }

        $controller = new $controller();

        if (! method_exists($controller,$method))
            throw_exception("cant find method $method in {$currentRoute['controller']} !");

        $request = service('RequestService');
        $request->put($this->matches);
        echo $controller->$method($request);
    }

    public function middleware(array|string $middlewares = []){
        $lastKey = array_key_last($this->routes);
        if (is_string($middlewares))
            $middlewares = [$middlewares];

        $this->routes[$lastKey]['middlewares'] = $middlewares;
        return $this;
    }

    private function checkMiddlewares($route)
    {
        $middlewares = $this->currentRoute['middlewares'] ?? [];
        foreach($middlewares as $routeMiddleware){
            $routeMiddleware = strtolower($routeMiddleware);
            if(! method_exists(MiddlewareService::class , $routeMiddleware ))
                throw_exception("cant find middleware $routeMiddleware ! ");
            MiddlewareService::$routeMiddleware();
        }
    }

}