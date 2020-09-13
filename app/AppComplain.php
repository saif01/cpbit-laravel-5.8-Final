<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppComplain extends Model
{
    protected $fillable = ['user_id', 'category', 'subcategory', 'details', 'process', 'doc1', 'doc2', 'doc3', 'doc4', 'status'];
}
