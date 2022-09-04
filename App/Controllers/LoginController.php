<?php

namespace App\Controllers;

use App\Core\Services\AuthService;
use App\kernel;
use App\Models\User;
use App\Core\Services\RequestService;
use Exception;
use Plasticbrain\FlashMessages\FlashMessages;

class LoginController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(){
        return view('auth.login');
    }

    public function logout(){

        if (AuthService::check()) {
            AuthService::logout();
        }
        return redirect('login');
    }

    /**
     * @throws Exception
     */
    public function confirm(RequestService $request){

        $data = $this->validation($request->all(),[
        'email'=>"required|email",
        'password'=>"required|min:6|max:10|confirm"
        ]);

        if ($data){
            $user = (new User())->where('email',$data['email'])->first();

            if (password_verify($data['password'],$user->password)){
                AuthService::login($user,!! $request->get('remember'));
                return redirect('profile');
            }else{
                (new FlashMessages())->error('cant find user with this username and password ! try again ...');
            }
        }

        return redirect('login');


    }


}