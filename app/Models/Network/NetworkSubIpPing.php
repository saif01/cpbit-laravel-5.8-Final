<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Model;

class NetworkSubIpPing extends Model
{
    protected $fillable = ['ip', 'name', 'group_name', 'latancy', 'status'];
}
