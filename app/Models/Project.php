<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "projects";
 
    public $timestamps = true;
 
    protected $fillable = ["name", "division_id", "status", "description", "person"];


    /* get user division */

	public function division()
	{
	    return $this->belongsTo(Division::class);
	}


}


