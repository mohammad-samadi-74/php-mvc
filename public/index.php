<?php
require "./../vendor/autoload.php";
error_reporting(E_ALL);
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//make new Application
$app = (new \App\kernel())->saveApp();

//start session
@session_start(['cookie_lifetime' => eval("return " . $_ENV['SESSION_LIFE_TIME'] . ";")]);
date_default_timezone_set('Asia/Tehran');


$auth = service('AuthService');
$auth->checkAuthSessionLifeTime();
$router = service('RouterService');
$blade = service('BladeService');

//add routes
require './../routes/web.php';

//check current route
if ($router->dispatch()) {
    $router->runMethod();
} else {
    die('cant find this route !');
}