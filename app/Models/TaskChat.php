<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TaskChat extends Model
{
    protected $table = "task_chats";
    protected $fillable = ["task_id", "user_id", "description"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
