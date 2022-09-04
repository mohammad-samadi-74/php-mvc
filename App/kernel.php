<?php

namespace App;

use App\Core\library\Kernel as KernelCore;
use App\Core\Providers\AppServiceProvider;
use App\Core\Providers\GateServiceProvider;

class kernel extends KernelCore
{
    #Add Service Providers
    protected array $providers = [
        AppServiceProvider::class,
        GateServiceProvider::class
    ];

}