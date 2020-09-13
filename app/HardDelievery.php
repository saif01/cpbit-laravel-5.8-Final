<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HardDelievery extends Model
{
    protected $fillable = ['comp_id', 'name', 'contact', 'remarks', 'document', 'action_by', 'action_id'];

    public function adminUser()
    {
        return $this->hasOne('App\Admin', 'id', 'action_id');
    }
}
