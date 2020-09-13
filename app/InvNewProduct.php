<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvNewProduct extends Model
{
    protected $fillable = ['new_pro_id', 'category', 'subcategory', 'name', 'serial', 'document', 'remarks', 'purchase', 'warranty', 'give_st'];
}
