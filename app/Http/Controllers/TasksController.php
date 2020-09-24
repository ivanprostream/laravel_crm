<?php

namespace App\Http\Controllers;

use App\Helpers\MailerFactory;
use App\Models\Document;
use App\Models\Task;
use App\Models\TaskDocument;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\TaskChat;
use App\Models\Project;
use App\Models\TaskAssigned;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    protected $mailer;

    public function __construct(MailerFactory $mailer)
    {
        $this->middleware('admin:index-list_tasks|create-create_task|show-view_task|edit-edit_task|destroy-delete_task|getAssignTask-assign_task|getUpdateStatus-update_task_status|getTaskDocument-task_documents', ['except' => ['store', 'update', 'postAssignTask', 'postUpdateStatus', 'postTaskMessage', 'getTasksByStatus', 'getTaskDocument']]);
 
        //$this->mailer = $mailer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if(Auth::user()->is_admin == 1) {
            if (!empty($keyword)) {
                $query = Task::where('name', 'like', "%$keyword%");
            } else {
                $query = Task::latest();
            }
        }

        if(Auth::user()->is_admin == 0) {
            if (!empty($keyword)) {
                $query = Task::where('name', 'like', "%$keyword%");
            } else {

                $query = TaskAssigned::latest();

                $query->where(function ($query) {

                    $query->where('user_id', Auth::user()->id);
                });

            }
        }

        $tasks = $query->paginate($perPage);
        $status_type = 1;
 
        return view('pages.tasks.index', compact('tasks', 'status_type'));
    }

    /**
     * Display a listing of the resource by status.
     *
     * @return \Illuminate\View\View
     */
    public function getTasksByStatus(Request $request, $status)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if(Auth::user()->is_admin == 1) {
            if (!empty($keyword)) {
                $query = Task::where('name', 'like', "%$keyword%");
            } else {
                $query = Task::latest();
            }
        }

        if(Auth::user()->is_admin == 0) {
            if (!empty($keyword)) {
                $query = Task::where('name', 'like', "%$keyword%");
            } else {

                $query = TaskAssigned::latest();

                $query->where(function ($query) {

                    $query->where('user_id', Auth::user()->id);
                });
            }
        }

        $tasks = $query->paginate($perPage);
        $status_type = $status;
 
        return view('pages.tasks.index', compact('tasks', 'status_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = $this->getFormData();
 
        list($users, $statuses, $task_types, $projects, $documents) = $data;
 
        return view('pages.tasks.create', compact('users', 'documents', 'statuses', 'task_types', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->do_validate($request);
 
        $requestData = $request->all();
 
        if(isset($requestData['documents'])) {
 
            $documents = $requestData['documents'];
 
            unset($requestData['documents']);
 
            $documents = array_filter($documents, function ($value) {
                return !empty($value);
            });
        }

        if(isset($requestData['assigned_users']) && !empty($requestData['assigned_users'])){
            $assigned_users = $requestData['assigned_users'];
        }

        if(isset($requestData['assigned_divisions']) && !empty($requestData['assigned_divisions'])){
            $assigned_divisions = $requestData['assigned_divisions'];
            $assigned_users = User::whereIn('division_id', $assigned_divisions)->get();
            $assigned_users = Arr::pluck($assigned_users, 'id');
        }

 
        $requestData['created_by_id'] = Auth::user()->id;
        
        
        $task = Task::create($requestData);
 
        // insert documents
        if($task && $task->id) {
 
            if(isset($documents)) {
 
                $this->insertDocuments($documents, $task->id);
            }
        }

        // insert assigned users
        if($task && $task->id) {
 
            if(isset($assigned_users)) {
 
                $this->insertAssignedUsers($assigned_users, $task->id, $task->project_id);
            }
        }
 
        return redirect('admin/tasks')->with('flash_message', 'Задание добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        $selected_assigned_users = $task->assignedUsers()->pluck('name')->toArray();

        return view('pages.tasks.show', compact('task', 'selected_assigned_users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = $this->getFormData($id);
 
        list($users, $statuses, $task_types, $projects, $documents, $task, $selected_documents, $selected_assigned_users) = $data;
 
        return view('pages.tasks.edit', compact('users', 'statuses', 'task_types', 'projects', 'documents', 'task', 'selected_documents', 'selected_assigned_users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->do_validate($request);
 
        $requestData = $request->all();
 
        if(isset($requestData['documents'])) {
            $documents = $requestData['documents'];
            unset($requestData['documents']);
            $documents = array_filter($documents, function ($value) {
                return !empty($value);
            });
        }

        $requestData['modified_by_id'] = Auth::user()->id;
        
        $task = Task::findOrFail($id);
 
        $old_task_status = $task->status;
 
        $task->update($requestData);
 
 
        // delete documents if exist
        TaskDocument::where('task_id', $id)->delete();
 
        // insert documents
        if(isset($documents)) {
 
            $this->insertDocuments($documents, $id);
        }


        // delete assigned users if exist
        TaskAssigned::where('task_id', $id)->delete();

        if(isset($requestData['assigned_users']) && !empty($requestData['assigned_users'])){
            $assigned_users = $requestData['assigned_users'];
        }

        if(isset($requestData['assigned_divisions']) && !empty($requestData['assigned_divisions'])){
            $assigned_divisions = $requestData['assigned_divisions'];
            $assigned_users = User::whereIn('division_id', $assigned_divisions)->get();
            $assigned_users = Arr::pluck($assigned_users, 'id');
        }
 
        // insert documents
        if(isset($assigned_users)) {
 
            $this->insertAssignedUsers($assigned_users, $id, $task->project_id);
        }
 
        if(enableEmailNotification() == 1)
        {
            // send notifications emails
     
            // if(getSetting("enable_email_notification") == 1) {
     
            //     if (isset($requestData['assigned_user_id']) && $old_assign_user_id != $requestData['assigned_user_id']) {
     
            //         $this->mailer->sendAssignTaskEmail("Task assigned to you", User::find($requestData['assigned_user_id']), $task);
            //     }
     
            //     // if status get update then send a notification to both the super admin and the assigned user
            //     if($old_task_status != $requestData['status']) {
     
            //         $super_admin = User::where('is_admin', 1)->first();
     
            //         if($super_admin->id == $task->assigned_user_id) {
            //             $this->mailer->sendUpdateTaskStatusEmail("Task status update", User::find($task->assigned_user_id), $task);
            //         } else {
            //             $this->mailer->sendUpdateTaskStatusEmail("Task status update", User::find($task->assigned_user_id), $task);
     
            //             $this->mailer->sendUpdateTaskStatusEmail("Task status update", $super_admin, $task);
            //         }
     
            //     }
            // }
        }
 
        return redirect('admin/tasks')->with('flash_message', 'Задание обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        Task::destroy($id);

        $taskAssigned = TaskAssigned::where('task_id', '=', $id)->delete();

        $taskChat = TaskChat::where('task_id', '=', $id)->delete();

        $taskDocument = TaskDocument::where('task_id', '=', $id)->delete();
 
        if(enableEmailNotification() == 1) {
            //$this->mailer->sendDeleteTaskEmail("Задание удалено", User::find($task->assigned_user_id), $task);
        }
 
        return redirect('admin/tasks')->with('flash_message', 'Задание удалено!');
    }


    public function getTaskDocument(Request $request, $id, $task_id)
    {
        $task = Task::find($task_id);
        $user = \Auth::user()->id;
        if($task && $user){

            if($request->method() == 'POST'){
                $this->do_validate_document($request, 0);
 
                $requestData = $request->except(['_token']);
         
                if ($request->hasFile('file')) {
                    checkDirectory("documents");
                    $requestData['file'] = uploadFile($request, 'file', public_path('uploads/documents'));
                }
         
                $requestData['modified_by_id'] = Auth::user()->id;
                
                $document = Document::findOrFail($id);
         
                $document->update($requestData);
         
                return redirect('admin/tasks/'.$task_id )->with('flash_message', 'Документ обновлен!');
            }

            $document = Document::findOrFail($id);
            return view('pages.tasks.document', compact('document', 'task'));
        }
    }

 
 
    public function getUpdateStatus($id)
    {
        $task = Task::find($id);
 
        $statuses = TaskStatus::all();
 
        return view('pages.tasks.update_status', compact('task', 'statuses'));
    }
 
    public function postUpdateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);
 
        $task = Task::find($id);
 
        $task->update(['status' => $request->status]);
 
 
        if(enableEmailNotification() == 1 && !empty($task->assigned_user_id)) {
 
            $super_admin = User::where('is_admin', 1)->first();
 
            if($super_admin->id == $task->assigned_user_id) {
 
                $this->mailer->sendUpdateTaskStatusEmail("Task status update", User::find($task->assigned_user_id), $task);
            } else {
                $this->mailer->sendUpdateTaskStatusEmail("Task status update", User::find($task->assigned_user_id), $task);
 
                $this->mailer->sendUpdateTaskStatusEmail("Task status update", $super_admin, $task);
            }
        }
 
        return redirect('admin/tasks')->with('flash_message', 'Статус задачи обновлен!');
    }


    public function postTaskMessage(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $task = Task::find($id);
        $user = \Auth::user()->id;
        
        $role = TaskChat::create(['description' => $request->message, 'task_id' => $task->id, 'user_id' => $user]);


        return redirect('admin/tasks/'.$id);
    }
 
 
    /**
     * insert documents
     *
     *
     * @param $documents
     * @param $task_id
     */
    protected function insertDocuments($documents, $task_id)
    {
        foreach ($documents as $document) {
 
            $taskDocument = new TaskDocument();
 
            $taskDocument->document_id = $document;
 
            $taskDocument->task_id = $task_id;
 
            $taskDocument->save();
        }
    }

    /**
     * insert assigned users
     *
     *
     * @param $users
     * @param $task_id
     */
    protected function insertAssignedUsers($users, $task_id, $project_id)
    {
        foreach ($users as $user) {
 
            $taskUser = new TaskAssigned();
 
            $taskUser->task_id = $task_id;
            $taskUser->project_id = $project_id;
            $taskUser->user_id = $user;
 
            $taskUser->save();
        }
    }
    
 
 
    /**
     * do_validate
     *
     *
     * @param $request
     */
    protected function do_validate($request)
    {
        $this->validate($request, [
            'name'       => 'required',
            'project_id' => 'required',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date'
        ]);
    }

    /**
     * do_validate_document
     *
     *
     * @param $request
     */
    protected function do_validate_document($request, $is_create = 1)
    {
        $mimes = 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xls,xlsx,odt,dot,html,htm,rtf,ods,xlt,csv,bmp,odp,pptx,ppsx,ppt,potm';

        $this->validate($request, [
            'name' => 'required',
            'file' => ($is_create == 0? $mimes:"required|" . $mimes)
        ]);
    }
 
 
    /**
     * get form data for the tasks form
     *
     *
     *
     * @param null $id
     * @return array
     */
    protected function getFormData($id = null)
    {
        $users = User::where('is_active', 1)->get();
 
        $statuses = TaskStatus::all();
 
        $task_types = TaskType::all();
 
        $projects = Project::all();
 
        if(Auth::user()->is_admin == 1) {
            $documents = Document::where('status', 1)->get();
        } else {
            $super_admin = User::where('is_admin', 1)->first();
 
            $documents = Document::where('status', 1)->where(function ($query) use ($super_admin) {
                $query->where('created_by_id', Auth::user()->id);
            })->get();
        }
 
        if($id == null) {
 
            return [$users, $statuses, $task_types, $projects, $documents];
        }
 
        $task = Task::findOrFail($id);
 
        $selected_documents = $task->documents()->pluck('document_id')->toArray();

        $selected_assigned_users = $task->assignedUsers()->pluck('user_id')->toArray();
 
        return [$users, $statuses, $task_types, $projects, $documents, $task, $selected_documents, $selected_assigned_users];
    }
}
