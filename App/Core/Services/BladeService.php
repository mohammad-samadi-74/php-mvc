<?php

namespace App\Core\Services;


use Philo\Blade\Blade;

class BladeService
{
    protected null|object $blade;

    protected string $viewsPath = "";
    protected string $cachePath = "";

    public function __construct()
    {
        $this->viewsPath = dirname(__DIR__,3) .  '\resource\views';
        $this->cachePath = dirname(__DIR__,3) .  '\resource\cache';

        $this->blade = new Blade($this->viewsPath, $this->cachePath);
    }

    public function getBlade(): object|null
    {
        return $this->blade;
    }
}