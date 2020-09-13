<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class TestMail2 extends Mailable
{
    use Queueable, SerializesModels;

    public  $attachments;
    public  $mailData;

    // public $file;
    // public $mime;
    // public $as;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $attachments)
    {
        $this->mailData = $mailData;
        $this->attachments = $attachments;

        // $this->file =  $attachments->file;
        // $this->mime =  $attachments->mime;
        // $this->as =  $attachments->as;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($attachments)
    {


        $message = $this->subject('New research request')->view('mail.test-mail');

        // foreach ($this->attachments as $attachment) {
        //     $message->attach($attachment['file'], $attachment['options']);
        // }

        $message->attach($attachments->file, ['as' => $attachments->as, 'mime' => $attachments->mime]);

        return $message;


    }
}
