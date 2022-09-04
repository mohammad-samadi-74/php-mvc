<?php

namespace App\Core\library;

use App\Core\Services\MailService;
use PHPMailer\PHPMailer\PHPMailer;

trait Mailable
{
    protected PHPMailer $mailer;
    protected array $data;

    /**
     * @param string $value
     * @return $this
     */
    public function subject(string $value = ''): static
    {
        if (!empty($value))
            $this->data['subject'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @param null $name
     * @return $this
     */
    public function to($value, $name = null): static
    {
        $this->data['to']['email'] = $value;
        if (isset($name))
            $this->data['to']['name'] = $name;

        return $this;
    }

    /**
     * @param $value
     * @param null $name
     * @return $this
     */
    public function from($value, $name = null): static
    {
        $this->data['from']['email'] = $value;
        if (isset($name))
            $this->data['from']['name'] = $name;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function cc($value): static
    {
        $this->data['cc'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function bcc($value): static
    {
        $this->data['bcc'] = $value;
        return $this;
    }

    public function replyTo($value, $name = null): static
    {
        $this->data['replyTo']['email'] = $value;
        if (isset($name))
            $this->data['replyTo']['name'] = $name;
        return $this;
    }

    public function body(string $value = ''): static
    {
        if (!empty($value))
            $this->data['body'] = $value;
        return $this;
    }
}