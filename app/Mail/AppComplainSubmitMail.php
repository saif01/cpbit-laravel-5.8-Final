<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppComplainSubmitMail extends Mailable
{
    use Queueable, SerializesModels;


    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('mail.user.app-complain-submit');
        return $this->from('it-noreply@cpbangladesh.com')
                    ->subject('Application Complain : ' . $this->mailData->compNumber)
                    ->view('mail.user.app-complain-submit')
                    ->with('mailData', $this->mailData);

    }
}
