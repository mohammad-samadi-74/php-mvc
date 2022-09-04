<?php

use JetBrains\PhpStorm\Pure;

if (!function_exists('service')){
    function service($name){
        if (\App\kernel::registered()){
            $app = \App\kernel::getApp();
            return $app->getService($name,$app);
        }
    }
}

if (!function_exists('throw_exception')){
    function throw_exception($message){
        throw new Exception($message);
    }
}

if (!function_exists('view')){
    function view($view_address,$data = []){
        $blade = service('BladeService')->getBlade();
        echo $blade->view()->make($view_address,$data)->render();
    }
}

if (!function_exists('env')){
    function env($const){
        return $_ENV[$const];
    }
}


if (!function_exists('throw_exception')){
    function throw_exception($message): void
    {
       throw new \Exception($message);
    }
}

if (!function_exists('asset')){
    #[Pure] function asset($address)
    {
        return env("APP_URL").$address;
    }
}

if (!function_exists('url')){
     function url($address='',$args=[])
    {
        return service('RedirectService')->address($address,$args,false);
    }
}

if (!function_exists('redirect')){
    function redirect(string $address = null , array $args = [])
    {
        $service = service('RedirectService');
        if(isset($address)){
           $service->route($address,$args ?? []);
        }else{
            return $service;
        }
    }
}

if (!function_exists('route')){
    function route($routeName = '',$args=[])
    {
        return service('RedirectService')->getRoute($routeName,$args);
    }
}


if (!function_exists('old')){
    function old($field,$default = null)
    {
        return $_SESSION[$field] ?? $default ?? '' ;
    }
}

if (!function_exists('showErrors')){
    function showErrors()
    {
        $messages = new \Plasticbrain\FlashMessages\FlashMessages();
        $messages->display();
    }
}

if (!function_exists('auth')){
    function auth()
    {
        return service('AuthService');
    }
}

if (!function_exists('random')){
    function random(int $length = 16): string
    {
        $a = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYSZ*_";

        $randomString = "";
        for($i=0;$i<$length;$i++){
            $randomString .= $a[rand(0,strlen($a)-1)];

        }

        return $randomString;
    }
}