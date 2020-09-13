<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsUser extends Model
{
    protected $fillable = ['user_id', 'access'];

}
