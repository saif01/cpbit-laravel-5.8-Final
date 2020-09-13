<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkSubIp extends Model
{
    protected $fillable = ['ip', 'name', 'group_name', 'status'];
}
