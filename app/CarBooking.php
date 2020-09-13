<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{
    protected $fillable = ['car_id', 'user_id', 'driver_id', 'start', 'end', 'destination', 'purpose', 'status'];
}
