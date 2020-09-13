<?php

namespace App\Models\Corona;

use Illuminate\Database\Eloquent\Model;

class CoronaOthersTemp extends Model
{
    protected $fillable = [
        'name','from', 'to', 'temp', 'remarks','temp_location','temp_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'temp_by');
    }
}
