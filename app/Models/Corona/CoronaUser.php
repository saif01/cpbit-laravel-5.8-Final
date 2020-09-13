<?php

namespace App\Models\Corona;

use Illuminate\Database\Eloquent\Model;

use App\Models\Corona\CoronarUserTemp;

class CoronaUser extends Model
{
    protected $fillable = [
        'id_number', 'name', 'department', 'remarks'
    ];

    public function tempData(){

        return $this->hasMany(CoronarUserTemp::class, 'user_id');
    }
}
