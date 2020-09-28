<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Models\Task;
use App\Models\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin:index-show_calendar|postTasksByUser-show_calendar');
    }

    public function index()
    {   
        $users = User::all();
        $eventData = $this->getTaskStatusByDate();
 
        list($events, $countPending, $countInProgress, $countFinished) = $eventData;
 
        $events_js_script = '<script>var events = '.json_encode($events).'</script>';
 
        return view('pages.calendar.index', compact('events_js_script', 'countPending', 'countInProgress', 'countFinished', 'users'));
    }

    public function postTasksByUser(Request $request)
    {
        $users = User::all();

        $requestData = $request->all();

        $eventData = $this->getTaskStatusByDate($requestData['user_id']);
        
 
        list($events, $countPending, $countInProgress, $countFinished) = $eventData;
 
        $events_js_script = '<script>var events = '.json_encode($events).'</script>';
 
        return view('pages.calendar.index', compact('events_js_script', 'countPending', 'countInProgress', 'countFinished', 'users'));
    }

    /**
     * get all tasks by date
     *
     * retrieves all tasks by dates and categorizes them into pending, in progress, finished
     * according to the date
     *
     * @return array
     */
    protected function getTaskStatusByDate($user = '')
    {
        // if not admin user show tasks if assigned to or created by that user
        if(Auth::user()->is_admin == 0) {
            $pending_tasks = DB::table('task')
            ->select('task.id', 'name', 'start_date', 'end_date', 'status', 'priority')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->whereIn('status', [1, 4])
            //->orWhere('status', 4)
            ->where('created_by_id', Auth::user()->id);

            $tasks_in_progress = DB::table('task')
            ->select('task.id', 'name', 'start_date', 'end_date', 'status', 'priority')
            ->join('task_assigned', 'task_assigned.task_id', '=', 'task.id')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('status', 1)
            ->where('task_assigned.user_id', Auth::user()->id);

            $finished_tasks = DB::table('task')
            ->select('task.id', 'name', 'start_date', 'end_date', 'status', 'priority')
            ->join('task_assigned', 'task_assigned.task_id', '=', 'task.id')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('status', 4)
            ->where('task_assigned.user_id', Auth::user()->id);
        }

        if(Auth::user()->is_admin == 1 &&  empty($user)) {
            $pending_tasks = Task::whereNotNull('start_date')->whereNotNull('end_date')->where('status', 1);
 
            $tasks_in_progress = Task::whereNotNull('start_date')->whereNotNull('end_date')->where('status', 1);
 
            $finished_tasks = Task::whereNotNull('start_date')->whereNotNull('end_date')->where('status', 4);
        }

        if(Auth::user()->is_admin == 1 && $user > 0) {
            $pending_tasks = Task::select('task.id', 'name', 'start_date', 'end_date', 'status')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->whereIn('status', [1, 4])
            ->where('created_by_id', $user);

            $tasks_in_progress = DB::table('task')
            ->select('task.id', 'name', 'start_date', 'end_date', 'status', 'priority')
            ->join('task_assigned', 'task_assigned.task_id', '=', 'task.id')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            // ->where('start_date', '<=', date("m/d/Y"))
            // ->where('end_date', '>=', date("m/d/Y"))
            ->where('status', 1)
            ->where('task_assigned.user_id', $user);

            $finished_tasks = DB::table('task')
            ->select('task.id', 'name', 'start_date', 'end_date', 'status', 'priority')
            ->join('task_assigned', 'task_assigned.task_id', '=', 'task.id')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('status', 4)
            ->where('task_assigned.user_id', $user);
        }
 
        $pending_tasks = $pending_tasks->get();
        $tasks_in_progress = $tasks_in_progress->get();
        $finished_tasks = $finished_tasks->get();
 
        $pending_events = [];
        $in_progress_events = [];
        $finished_events = [];
 
        foreach ($pending_tasks as $task) {
 
            $pending_events[] = ["title" => $task->name,
                "start" => date("Y-m-d", strtotime($task->start_date)),
                "end" => date("Y-m-d", strtotime($task->end_date)),
                "backgroundColor" => "#e83e8c",
                "borderColor" => "#e83e8c",
                "className" => "pending",
                "description" => 
                    "<strong>Начало задания:</strong> " . date("d-m-Y", strtotime($task->start_date)) . "<br/>" .
                    "<strong>Конец задания:</strong> " . date("d-m-Y", strtotime($task->end_date)) . "<br/>" .
                    "<strong>Статус:</strong> " . getStyleStatus($task->status) . "<br/>" .
                    "<strong>Приоритет:</strong> " . getStylePriority($task->priority) .

                    "<a href='". url('/admin/tasks/' . $task->id) ."' class='btn btn-info btn-sm'><i class='fa fa-eye'></i> Просмотр</a>"
                ];
        }
 
        foreach ($tasks_in_progress as $task) {
 
            $in_progress_events[] = ["title" => "(В работе) " . $task->name,
                "start" => date("Y-m-d", strtotime($task->start_date)),
                "end" => date("Y-m-d", strtotime($task->end_date)),
                "backgroundColor" => "#007bff",
                "borderColor" => "#007bff",
                "className" => "in-progress",
                "description" => 
                    "<strong>Начало задания:</strong> " . date("d-m-Y", strtotime($task->start_date)) . "<br/>" .
                    "<strong>Конец задания:</strong> " . date("d-m-Y", strtotime($task->end_date)) . "<br/>" .
                    "<strong>Статус:</strong> " . getStyleStatus($task->status) . "<br/>" .
                    "<strong>Приоритет:</strong> " . getStylePriority($task->priority) .
                    "<a href='". url('/admin/tasks/' . $task->id) ."' class='btn btn-info btn-sm'><i class='fa fa-eye'></i> Просмотр</a>"
            ];
        }
 
        foreach ($finished_tasks as $task) {
 
            $finished_events[] = ["title" => $task->name . " - выполнен",
                "start" => date("Y-m-d", strtotime($task->start_date)),
                "end" => date("Y-m-d", strtotime($task->end_date)),
                "backgroundColor" => "#00a65a",
                "borderColor" => "#00a65a",
                "className" => "finished",
                "description" => 
                    "<strong>Начало задания:</strong> " . date("d-m-Y", strtotime($task->start_date)) . "<br/>" .
                    "<strong>Конец задания:</strong> " . date("d-m-Y", strtotime($task->end_date)) . "<br/>" .
                    "<strong>Статус:</strong> " . getStyleStatus($task->status) . "<br/>" .
                    "<strong>Приоритет:</strong> " . getStylePriority($task->priority) .
                    "<a href='". url('/admin/tasks/' . $task->id) ."' class='btn btn-info btn-sm'><i class='fa fa-eye'></i> Просмотр</a>"
            ];
        }
 
        return [array_merge($pending_events, $in_progress_events, $finished_events),
            count($pending_events),
            count($in_progress_events),
            count($finished_events)
            ];
    }

    
}
