<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NetworkController extends Controller
{
    public function Index(){
        return view('admin.network.index');
    }
}
