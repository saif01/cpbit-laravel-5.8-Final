<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkMainIpPing extends Model
{
    protected $fillable = ['ip', 'name', 'latancy', 'status'];
}
