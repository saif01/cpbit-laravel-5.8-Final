<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class HardComplian extends Model
{
    protected $fillable = ['user_id', 'category', 'subcategory', 'tools', 'computer_name', 'details', 'process', 'documents', 'warrenty', 'delivery', 'status'];

    // public function user()
    // {
    //     //return $this->hasOne('App\User', 'foreign_key', 'local_key');
    //     return $this->hasOne('App\User', 'id', 'user_id');
    // }


}
