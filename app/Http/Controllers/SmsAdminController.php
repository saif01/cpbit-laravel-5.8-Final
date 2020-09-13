<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsAdminController extends Controller
{
    public function Index(){
        return view('admin.sms.index');
    }
}
