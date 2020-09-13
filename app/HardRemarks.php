<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HardRemarks extends Model
{
    protected $fillable = ['comp_id', 'process', 'remarks', 'document', 'action_by', 'action_id'];
}
