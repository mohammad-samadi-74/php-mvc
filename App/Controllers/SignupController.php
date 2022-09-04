<?php

namespace App\Controllers;

use App\Core\Services\RequestService;
use App\kernel;
use App\Models\User;
use Exception;

class SignupController extends Controller
{
    /**
     * @throws Exception
     */
    public function signup()
    {
        return view('auth.signup');
    }

    /**
     * @throws Exception
     */
    public function confirm(RequestService $request)
    {

        $data = $this->validation($request->all(), [
            'name' => "required|min:3",
            'email' => "required|email|unique:users,email",
            'password' => "required|min:6|max:10|confirm"
        ]);

        if ($data) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $user = (new User())->create($data);
            auth()->login($user);
            return redirect('home');
        }
        return redirect('signup');


    }
}