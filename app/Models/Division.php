<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = "divisions";
 
    public $timestamps = true;
 
    protected $fillable = ["name", "person_name", "person_phone", "description"];
    
}

