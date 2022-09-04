<?php

namespace App\Controllers;

class AdminController extends Controller
{
    public function adminPanel(){
        return view('admin.panel');
    }
}