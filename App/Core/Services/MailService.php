<?php

namespace App\Core\Services;

use App\Core\library\Mailable;
use JetBrains\PhpStorm\Pure;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    use Mailable;

    #[Pure] public function __construct()
    {
        $this->mailer = new PHPMailer();
    }

    private function addOptions(){
        $mail = $this->mailer;

        try {
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAIL_HOST');                 //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');             //SMTP username
            $mail->Password   = env('MAIL_PASSWORD');             //SMTP password
            $mail->Port       = env('MAIL_PORT');                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        }catch(\Exception $e){
            die($e->getMessage());
        }
    }

    public function sendMail(){
        extract( $this->data);
        $this->addOptions();
        $mail = $this->mailer;

        try {
            $mail->setFrom($from['email'] ?? 'example@gmail.com', $from['name'] ?? '');
            $mail->addAddress($to['email'] ?? 'example@gmail.com', $to['name'] ?? '');

            if (isset($replyTo))
                $mail->addReplyTo($replyTo['email'] ?? 'example@gmail.com', $replyTo['name'] ?? '');

            if (isset($cc))
                $mail->addCC($cc);

            if (isset($bcc))
                $mail->addBCC($bcc);

            $mail->isHTML(true);
            $mail->Subject = $subject ?? '';
            $mail->Body    =  $body ?? '';

//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        }catch(\Exception $e){
            die($e->getMessage());
        }

    }

}