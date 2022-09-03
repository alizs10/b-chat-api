<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordToken extends Mailable
{
    use Queueable, SerializesModels;

    protected $reset_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset_token)
    {
        $this->reset_token = $reset_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.auth.forgot-password')
        ->with('reset_password_token', $this->reset_token);
    }
}
