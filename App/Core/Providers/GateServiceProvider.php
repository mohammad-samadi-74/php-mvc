<?php

namespace App\Core\Providers;

use App\Core\library\ServiceProvider;
use App\Core\Services\GateService;

class GateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->addService(GateService::class);
    }

    public function boot()
    {
        //define gates
        service('GateService')->define('admin' , function(){
            return false;
        });
    }


}