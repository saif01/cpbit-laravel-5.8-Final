<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkIp extends Model
{
    protected $fillable = ['ip', 'name', 'status'];
}
