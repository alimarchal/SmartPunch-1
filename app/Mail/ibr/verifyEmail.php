<?php

namespace App\Mail\ibr;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $ibr;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ibr)
    {
        $this->ibr = $ibr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ibr = $this->ibr;
        return $this->subject('Verify Email')
            ->view('ibr.auth.verify-email', compact('ibr'));
    }
}
