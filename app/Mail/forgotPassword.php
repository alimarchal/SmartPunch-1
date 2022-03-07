<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $password;
    protected $ibr_no;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password, $ibr_no)
    {
        $this->password = $password;
        $this->ibr_no = $ibr_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $password = $this->password;
        $ibr_no = $this->ibr_no;
        return $this->subject('Forgot password')
            ->view('email.forgotPassword', compact('password', 'ibr_no'));
    }
}
