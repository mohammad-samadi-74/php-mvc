<?php

namespace App\Core\Services;

use App\Core\Facades\Cookie;
use App\Core\Facades\Request;
use App\Models\Model;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use JetBrains\PhpStorm\Pure;



class AuthService
{
    protected static mixed $auth = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!session_id()) {
            die('please start sessions to continue...');
        }

        if (Cookie::get('remember') && Cookie::get('remember')->expired_at > Carbon::now()->format('Y/m/d H:i:s')) {
            $user = (new User())->where('email', Cookie::get('remember')->email)->first();
            self::$auth = $user;
        }else {
            self::$auth = isset($_SESSION['auth']) ? (new user)->find((int)json_decode($_SESSION['auth'], true)['user_id']) : null;
        }

    }

    /**
     * @return bool
     */
    public static function check(): bool
    {
        return !!self::$auth;
    }


    /**
     * @return mixed
     */
    #[Pure] public static function user(): mixed
    {
        if (self::check())
            return (self::$auth);
        return null;
    }


    /**
     * @param int|object $user
     * @param bool $remember
     * @return bool
     * @throws Exception
     */
    public static function login(int|object $user, bool $remember = false): bool
    {

        self::logout();

        $user = is_int($user) ? (new User)->find($user) : $user;
        if (!$user instanceof Model)
            throw_exception("user data for login isnt correct !");

        self::$auth = ['user' => $user, 'login_at' => Carbon::now()->toJSON()];

        if ($remember){
            $expired_at = Carbon::now()->addSeconds(eval("return ".$_ENV['SESSION_LIFE_TIME'].";"))->format('Y/m/d H:i:s');
            Cookie::set('remember', ['email' => $user->email, 'expired_at' => $expired_at],$expired_at);
        }

        $_SESSION['auth'] = json_encode(['user_id' => $user->id, 'login_at' => Carbon::now()->format('Y/m/d H:i:s')]);

        return true;
    }


    /**
     * @return bool
     */
    public static function logout(): bool
    {
        self::resetAuth();
        return true;
    }

    protected static function resetAuth()
    {
        if (isset($_SESSION['auth']))
            unset($_SESSION['auth']);
        if (isset($_COOKIE['remember']))
            setcookie('remember', "", time() - 100000);
        self::$auth = null;
        Request::resetRequests();
    }


    public function checkAuthSessionLifeTime()
    {
        if (self::check()) {

            $loginTime = Carbon::createFromTimeString(json_decode($_SESSION['auth'])->login_at);
            $now = Carbon::now();

            if ($loginTime->diffInSeconds($now, false) >= eval('return ' . env('SESSION_LIFE_TIME') . ';')) {
                self::logout();
            }
        }
    }
}