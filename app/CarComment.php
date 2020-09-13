<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarComment extends Model
{
    protected $fillable = ['booking_id','car_id', 'user_id', 'driver_id', 'cost', 'driver_rating', 'start_mileage', 'end_mileage', 'status'];
}
