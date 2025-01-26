<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Создание нового экземпляра письма
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Построение письма
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Восстановление пароля')
        ->view('email.reset_password')
        ->with(['token' => $this->token]);
    }
}
