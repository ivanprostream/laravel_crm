<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
 
    public $timestamps = true;
 
    protected $table = "task";
 
    protected $fillable = ["name", "priority", "status", "project_id", "type_id", "start_date", "end_date", "contact_type", "description", "created_by_id", "modified_by_id"];
 
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
 
 
    /* get assigned to user object */

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
 
 
    /* get status object for this task */

    public function getStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'status');
    }
 
 
    /* get type object for this task */

    public function type()
    {
        return $this->belongsTo(TaskType::class, 'type_id');
    }
 
 
    /* get contact object attached with this task */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
 
    /* get all documents for this task */
    
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'task_document', 'task_id');
    }

    /* get all assigned users for this task */

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_assigned', 'task_id', 'user_id');
    }

    /* get chat messages */

    public function messages()
    {
        return $this->hasMany(TaskChat::class)->orderBy('id', 'DESC');
    }















}
