<?php

namespace App\Models\Corona;

use Illuminate\Database\Eloquent\Model;

class CoronarUserTemp extends Model
{
    protected $fillable = [
        'user_id','id_number', 'name', 'department', 'date','temp_1','temp_1_by', 'temp_2','temp_2_by', 'temp_3','temp_3_by', 'temp_4','temp_4_by','temp_5','temp_5_by', 'temp_final', 'temp_1_location','temp_2_location','temp_3_location','temp_4_location', 'temp_5_location','temp_1_time','temp_2_time','temp_3_time','temp_4_time', 'temp_5_time', 'bu_location'
    ];
}
