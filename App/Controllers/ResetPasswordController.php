<?php

namespace App\Controllers;

use App\Core\Facades\Mail;
use App\Core\Facades\Session;
use App\Core\Services\MailService;
use App\Core\Services\RequestService;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function resetPassword()
    {
        return view('auth.resetPassword');
    }

    public function resetPasswordConfirm(RequestService $request)
    {

        $email = Session::getFlash('email') ? array_merge($request->all(), ['email' => Session::getFlash('email')]) : $request->all();
        $data = $this->validation($email, [
            'email' => 'required|email'
        ]);


        if ($data) {

            $user = (new User())->where('email', $data['email'])->first();

            if (!isset($user)) {
                $this->flash->error("There Is not Any User With This Email {$data['email']}! try Again.");
                return redirect('/resetPassword');
            }

            $token = (new Token())->resetUserOldTokens($user->id)->create(['userId' => $user->id, 'token' => random(10), 'expired_at' => Carbon::now()->addMinutes(2)]);;

            if ((new User())->where('email',$data['email'])->first()->userHasActiveToken()){
                $this->emailTokenToUser($data['email'], $token);
            }

            Session::flash('email', $user->email);
            return redirect('/resetPassword/token');
        }

        return redirect('/resetPassword');
    }

    public function resetPasswordToken()
    {

        if (!\App\Core\Facades\Session::hasFlash('email')) {
            return redirect('/resetPassword');
        }
        $email = \App\Core\Facades\Session::getFlash('email');

        Session::reFlash('email');

        $token = (new Token())->findOrCreateToken(((new User())->where('email', $email)->first())->id);

        if (! (new User())->where('email',$email)->first()->userHasActiveToken()){
            $this->emailTokenToUser($email, $token);
        }


        $expiredAt = $token->expired_at;

        return view('auth.resetPasswordVerify', compact('email', 'expiredAt'));
    }

    public function resetPasswordTokenConfirm(RequestService $request)
    {
        $email = Session::getFlash('email1') ? array_merge($request->all(), ['email' => Session::getFlash('email')]) : $request->all();
        $data = $this->validation(array_merge($request->all(), $email), [
            'token' => 'required',
            'email' => 'email'
        ]);


        if ($data) {
            $user = (new User())->where('email', $data['email'])->first();

            if (!isset($user)) {
                $this->flash->error("Cant Find Any User With Email {$data['email']}");
                Session::reFlash('email');
                return redirect('/resetPassword/token');
            }


            $token = (new Token())->where('userId', $user->id)->first();


            if (!isset($token) || $token->token !== trim($data['token']) || (Carbon::make($token->expired_at)->timestamp <= Carbon::now()->timestamp)) {

                $this->flash->error("You Enter Wrong Token or Token Is Expired !");
                Session::reFlash('email');
                return redirect('/resetPassword/token');
            }

            (new Token())->resetUserOldTokens($user->id);
            Session::reFlash('email');
            return redirect('/resetPassword/newPassword');
        }

        Session::reFlash('email');
        return redirect('/resetPassword/token');

    }

    public function newPassword()
    {
        Session::reFlash('email');
        return view('auth.newPasswordVerify');
    }

    public function newPasswordVerify(RequestService $request)
    {

        $req = Session::getFlash('email') ? array_merge($request->all(), ['email' => Session::getFlash('email')]) : $request->all();

        $data = $this->validation($req, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:10|confirm',
        ]);

        if ($data) {
            $user = (new User())->where('email', $data['email'])->first();

            if (!isset($user)) {
                $this->flash->error("Cant Find Any User With Email {$data['email']}");
                Session::reFlash('email');
                return redirect('/resetPassword/token');
            }

            $user->update(['password' => password_hash($data['password'], PASSWORD_DEFAULT)]);

            $this->flash->success('Password Has Changed Successfully.');
            return redirect('/home');
        }

        Session::reFlash('email');
        return redirect('/resetPassword/newPassword');
    }

    public function newPasswordGenerate()
    {
        $email = $_POST['email'] ?? null;

        $user = (new User())->where('email', $email)->first();

        $status = false;
        if (isset($user)) {
            (new Token())->findOrCreateToken($user->id);
            $status = true;
        }

        Session::reFlash('email');
        echo json_encode(['status' => $status]);
    }

    public function emailTokenToUser($email, $token)
    {
        (new MailService)->to($email)
            ->subject('Verify Password Reset : ')
            ->body("<div><h3 class='padding:1rem'>Your Resset Password Token Is : </h3><p style='text-align:center;margin: 2rem;padding:1rem;background-color: whitesmoke'><code>{$token->token}</code></p></div>")
            ->sendMail();
    }
}