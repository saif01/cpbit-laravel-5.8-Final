<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkSubIpPing extends Model
{
    protected $fillable = ['ip', 'name', 'group_name', 'latancy', 'status'];
}
