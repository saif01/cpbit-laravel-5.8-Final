<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['name', 'number', 'temporary', 'capacity', 'image', 'image2', 'image3', 'remarks', 'last_use', 'status'];
}
