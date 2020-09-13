<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $fillable = ['room_id', 'user_id', 'start', 'end', 'purpose', 'status'];
}
