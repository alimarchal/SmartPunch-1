<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPSent extends Mailable
{
    use Queueable, SerializesModels;

    protected $otp;
    protected $ibr_no;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->otp = $user->otp;
        $this->ibr_no = $user->ibr_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $otp = $this->otp;
        $ibr_no = $this->ibr_no;
        return $this->subject('Email verification')
            ->view('email.otpSent', compact('otp', 'ibr_no'));
    }
}
