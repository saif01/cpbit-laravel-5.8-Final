<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopbarAddress extends Model
{
    protected $fillable = ['project', 'address', 'contact_name', 'office_time', 'office_day'];
}
