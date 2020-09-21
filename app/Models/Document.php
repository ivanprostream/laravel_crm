<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Model
{
    //use SoftDeletes;
 
    protected $table = "document";
 
    public $timestamps = true;
 
    protected $fillable = ["name", "file", "publish_date", "expiration_date", "created_by_id", "modified_by_id"];
 
    /* get created by user object */

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
 
    /* get modified by user object */

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by_id');
    }

}
