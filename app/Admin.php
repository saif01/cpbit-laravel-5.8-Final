<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'login', 'password', 'name', 'email', 'image', 'department', 'location', 'contact', 'office_id', 'status', 'car', 'room', 'law', 'hard', 'app', 'inventory', 'super', 'admin_cr','user_cr'
    ];
}
