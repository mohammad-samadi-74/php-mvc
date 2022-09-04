<?php

namespace App\Core\Services;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class RedirectService
{
    /**
     * @var array
     */
    protected array $routes = [];
    /**
     * @var array
     */
    protected array $currentRoute;
    /**
     * @var string
     */
    protected string $redirectMethod = 'get';

    public function __construct()
    {
        $this->routes = service('RouterService')->getRoutes();
        $this->currentRoute = service('RouterService')->getCurrentRoute();
        $this->currentRoute = ['address' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];
    }

    /**
     * @param $url
     * @param array $args
     * @return string
     */
    public function address($url, array $args = []): string
    {
        $method = 'get';
        foreach ($this->routes as $key => $route) {
            if (preg_match($key, $url) == 1) {
                $method = $route['method'];
            }
        }

        $this->redirectMethod = $method;
        $url = env('APP_URL') . preg_replace('/^\//', '', $url);

        return $this->getUrlWithQueries($url, $args);
    }

    /**
     * @param $routeName
     * @param array $args
     * @return array|bool|string|null
     * @throws Exception
     */
    public function getRoute($routeName, array $args = []): array|bool|string|null
    {
        $address = false;
        array_map(function ($route) use ($routeName, $args, &$address) {

            if ($address) return;

            if (isset($route['name']) && $route['name'] === trim($routeName)) {
                $url = env('APP_URL') . $route['url'];

                if (strtolower($route['method']) === 'get') {
                    $address = $this->getUrlWithQueries($url, $args);

                    $this->redirectMethod = 'get';
                } else {

                    $address = $this->postUrlWithQueries($url, $args);
                    $this->redirectMethod = 'post';
                }
            }
        }, $this->routes);

        return $address;
    }


    /**
     * @param string $routeName
     * @param array $args
     * @return void
     * @throws Exception
     */
    public function route(string $routeName = '', array $args = [])
    {

        $address = $this->getRoute($routeName, $args);

        if (!$address) {
            $address = $this->address($routeName);
        }

        $this->saveLastRoute($this->currentRoute);

        if (strtolower($this->redirectMethod) == 'get') {
            ob_start();
            ob_end_flush();
            header('Location:' . $address);
        } else {
            return $this->redirectPost($address);
        }
        exit;
    }

    /**
     * @param string $url
     * @param array $args
     * @return string
     */
    protected function getUrlWithQueries(string $url, array $args): string
    {
        $query = '';
        $url = preg_replace('/^\//', '', $url);
        foreach ($args as $key => $value) {
            if (is_int($key)) {
                break;
            }

            $query .= "$key=$value&";
        }
        $query = "?" . $query;
        $query = substr($query, 0, strlen($query) - 1);
        return $url;


    }

    /**
     * @param string $url
     * @param array $args
     * @return string
     * @throws Exception
     */
    protected function postUrlWithQueries(string $url, array $args): string
    {
        $args = array_values($args);

        $url = preg_replace('/^\//', '', $url);
        $i = 0;
        while (preg_match('/\{[a-z0-9A-Z-]+\}/', $url) !== 0) {
            if (!isset($args[$i])) {
                throw_exception("Please Pass More Parameters to Route method !");
            }

            $url = preg_replace('/\{[a-zA-Z0-9-]+\}/', $args[$i], $url, 1);
            $i++;
        }

        return $url;
    }

    /**
     * @param array|string $address
     */
    private function redirectPost(array|string $address)
    {
        return view('layouts.redirect', ['address' => $address]);
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function back()
    {

        $route = isset($_SESSION['route']['back']) && !empty($_SESSION['route']['back']) ? $_SESSION['route']['back'] : null;


        if (is_null($route))
            exit;

        if (strtolower($route['method']) === 'get') {
            ob_start();
            ob_end_flush();
            header('Location: ' . $route['address']);
        } else {
            $this->redirectPost($route['address']);
        }
        exit;

    }

    /**
     * @param null $lastRoute
     */
    public function saveLastRoute($lastRoute = null)
    {
        $_SESSION['redirect']['back'] = $lastRoute ?? [];
    }

}