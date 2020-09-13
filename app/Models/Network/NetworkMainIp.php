<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Model;

class NetworkMainIp extends Model
{
    protected $fillable = ['ip', 'name', 'status', 'start', 'end'];
}
