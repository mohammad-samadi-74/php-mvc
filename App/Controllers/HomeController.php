<?php

namespace App\Controllers;

use App\Core\Facades\Cookie;
use App\Core\Facades\DB;
use App\Models\Article;
use App\Models\Permission;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;

class HomeController
{

    public function home()
    {
        return view('home');
    }


}