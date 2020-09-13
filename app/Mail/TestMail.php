<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Http\Request;
use File;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public  $mailData;
    public  $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //$this->mailData = $mailData;
        $this->data = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        //return $this->view('view.name');
        //return $this->from('syful5683@gmail.com')->subject('E-Mail Test')->view('mail.test-mail')->with('mailData', $this->mailData);

        if($request->file('file')){
            return $this->from('syful5683@gmail.com')->subject('E-Mail Test')->view('mail.test-mail')
                ->with('msg', $this->data)
                ->attach($request->file('file'), [

                    'as' => rand(100, 100000) . '.' . $request->file('file')->getClientOriginalExtension(),

                    'mime' => File::mimeType($request->file('file'))

                ]);
        }else{
            return $this->from('syful5683@gmail.com')->subject('E-Mail Test')->view('mail.test-mail')
                ->with('msg', $this->data);

        }


    }
}
