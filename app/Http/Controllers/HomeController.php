<?php

namespace App\Http\Controllers;

use App\Models\TaskAssigned;
use App\Models\Task;
use App\Models\TaskDocument;
use App\Models\TaskStatus;
use App\Models\TaskType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin:index-list_tasks|show-view_task|edit-edit_task|getAssignTask-assign_task|getUpdateStatus-update_task_status', ['except' => ['store', 'update', 'postAssignTask', 'postUpdateStatus', 'postTaskMessage', 'getTasksByStatus']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $tasks = TaskAssigned::where('user_id', Auth::user()->id)->get();

        return view('pages.home')->with(compact('tasks'));;
    }
}
