<?php

namespace App\Core\Providers;


use App\Core\library\ServiceProvider;
use App\Core\Services\AuthService;
use App\Core\Services\BladeService;
use App\Core\Services\CookieService;
use App\Core\Services\DBService;
use App\Core\Services\GateService;
use App\Core\Services\MailService;
use App\Core\Services\MiddlewareService;
use App\Core\Services\RedirectService;
use App\Core\Services\RequestService;
use App\Core\Services\RouterService;
use App\Core\Services\SessionService;
use App\Core\Services\ValidationService;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //Add BAse Services
        $this->addService(AuthService::class);
        $this->addService(MiddlewareService::class);
        $this->addService(ValidationService::class);
        $this->addService(RouterService::class);
        $this->addService(DBService::class);
        $this->addService(RequestService::class);
        $this->addService(BladeService::class);
        $this->addService(MailService::class);
        $this->addService(GateService::class);
        $this->addService(RedirectService::class);
        $this->addService(SessionService::class);
        $this->addService(CookieService::class);
    }

    public function boot()
    {

    }
}