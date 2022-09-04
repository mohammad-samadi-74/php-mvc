<?php

namespace App\Core\Services;

class MiddlewareService
{
    static public function auth(){
        if (! auth()->check()){
            return redirect('login');
        }
    }

    static public function guest(){
        if (auth()->check()){
            return redirect('home');
        }
    }
}