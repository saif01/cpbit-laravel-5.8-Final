<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'type', 'image', 'image2', 'image3', 'remarks', 'capacity', 'projector', 'status'];
}
