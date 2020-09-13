<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['car_id', 'name', 'contact', 'image', 'license', 'nid', 'leave_start', 'leave_end', 'status'];
}
