<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordToken extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $reset_password_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $reset_password_token)
    {
        $this->email = $email;
        $this->reset_password_token = $reset_password_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = env('APP_BASE_URL') . "/auth/reset-password/$this->email/$this->reset_password_token";
        return $this->view('mails.auth.forgot-password')
            ->with('url', $url);
    }
}
