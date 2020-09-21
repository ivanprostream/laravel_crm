<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssigned extends Model
{
    protected $table = "task_assigned";
    protected $fillable = ["task_id", "user_id"];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }


}
