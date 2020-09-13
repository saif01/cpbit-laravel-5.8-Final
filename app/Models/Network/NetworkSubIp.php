<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Model;

class NetworkSubIp extends Model
{
    protected $fillable = ['ip', 'name', 'group_name', 'status'];
}
