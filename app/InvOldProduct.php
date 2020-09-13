<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvOldProduct extends Model
{
    protected $fillable = ['category', 'subcategory', 'department', 'bu_location', 'name', 'serial', 'remarks', 'rec_name', 'rec_contact', 'rec_position'];
}
