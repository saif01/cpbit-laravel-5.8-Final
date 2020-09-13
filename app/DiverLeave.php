<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiverLeave extends Model
{
    protected $fillable = ['car_id', 'driver_id', 'start', 'end', 'status'];
}
