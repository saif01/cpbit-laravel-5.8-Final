<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\AppComplainSubmitMail;
use Illuminate\Support\Facades\Mail;

class MailSendCmsController extends Controller
{
    public function test(){

        $data = array(
            "title" => "hello Saif aaaaaaaaaaa",
            "description" => "test test test bbbbbbbbb"
        );

        Mail::to(['saifulislamw60@gmail.com','syful.cse.bd@gmail.com'])->send(new AppComplainSubmitMail($data));

        return "ok";

    }
}
