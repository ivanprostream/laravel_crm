<?php
 
use App\Models\Setting;
use App\Models\Task;
/**
 * upload file
 *
 *
 * @param $request
 * @param $name
 * @param string $destination
 * @return string
 */
function uploadFile($request, $name, $destination = '')
{
    $image = $request->file($name);
 
    $name = time().'.'.$image->getClientOriginalExtension();
 
    if($destination == '') {
        $destination = public_path('/uploads');
    }
 
    $image->move($destination, $name);
 
    return $name;
}
 
 
/**
 * add setting key and value
 *
 *
 * @param $key
 * @param $value
 * @return Setting|bool
 */
function addSetting($key, $value)
{
    if(Setting::where('setting_key', $key)->first() != null)
        return false;
 
    $setting = new Setting();
 
    $setting->setting_key = $key;
 
    $setting->setting_value = $value;
 
    $setting->save();
 
    return $setting;
}
 
/**
 * get setting value by key
 *
 * @param $key
 * @return mixed
 */
function getSetting($key)
{
    return ($setting = Setting::where('setting_key', $key)->first()) != null ? $setting->setting_value:null;
}
 
/**
 * check directory exists and try to create it
 *
 *
 * @param $directory
 */
function checkDirectory($directory)
{
    try {
        if (!file_exists(public_path('uploads/' . $directory))) {
            mkdir(public_path('uploads/' . $directory));
 
            chmod(public_path('uploads/' . $directory), 0777);
        }
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
 
/**
 * check if user has permission
 *
 *
 * @param $permission
 * @return bool
 */
function user_can($permission)
{
    return \Auth::user()->is_admin == 1 || \Auth::user()->can($permission);
}

/**
 * get Unread Messages
 *
 *
 * @return mixed
 */
function getUnreadMessages()
{
    $folder = \App\Models\MailboxFolder::where('id', 1)->first();

    $messages = \App\Models\Mailbox::join('mailbox_receiver', 'mailbox_receiver.mailbox_id', '=', 'mailbox.id')
        ->join('mailbox_user_folder', 'mailbox_user_folder.user_id', '=', 'mailbox_receiver.receiver_id')
        ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
        ->where('mailbox_receiver.receiver_id', \Auth::user()->id)
//                          ->where('parent_id', 0)
        ->where('mailbox_flags.is_unread', 1)
        ->where('mailbox_user_folder.folder_id', $folder->id)
        ->where('sender_id', '!=', \Auth::user()->id)
        ->whereRaw('mailbox.id=mailbox_receiver.mailbox_id')
        ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
        ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
        ->select(["*", "mailbox.id as id"])
        ->get();

    return $messages;
}

/**
 * getDivisions
 *
 *
 * @param null $status
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function getDivisions()
{
    return \App\Models\Division::all();
}


/**
 * getProjectStatus
 *
 *
 * @param $status
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function getProjectStatus($status)
{
    if($status == 1){
        return 'Активный';
    }elseif($status == 2){
        return 'Архивный';
    }
}


/**
 * getDivisions
 *
 *
 * @param null $status
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function getProjectsByDivision($id)
{
    return \App\Models\Project::where('division_id', $id)->where('status', 1)->get();
}
 
 
/**
 * get Users
 *
 *
 * @return mixed
 */
function getUsers()
{
    return \App\User::where('is_admin', 0)->where('is_active', 1)->get();
}

/**
 * get Email notice permission
 *
 *
 * @return mixed
 */
function enableEmailNotification()
{
    $result = \App\User::select('email_notice')->where('is_admin', 1)->first();
    return $result->email_notice;
}


/**
 * get Mailbox type name
 *
 *
 * @return mixed
 */
function getMailBoxTypeName($name)
{
    if($name == 'Inbox'){
        return 'Входящие';
    }elseif($name == 'Sent'){
        return 'Отправленные';
    }elseif($name== 'Drafts'){
        return 'Черновик';
    }elseif($name== 'Trash'){
        return 'Удаленные';
    }
}


/**
 * get Tasks by Last Day
 *
 *
 * @return mixed
 */
function getTasksByLastDay()
{
    $taskStatus = 1; // status In Work
    $user  = Auth::user()->id;
    $today = date('m/d/Y');

    $tasks = DB::table('task_assigned')
    ->select('task_assigned.user_id','task_assigned.task_id', 'task.*', 'task_status.name AS status_name', 'task_type.name AS type_name', 'users.name AS user_name')
    ->join('task','task.id','=','task_assigned.task_id')
    ->join('task_status','task_status.id','=','task.status')
    ->join('task_type','task_type.id','=','task.type_id')
    ->join('users','users.id','=','task.created_by_id')
    ->where('task_assigned.user_id', $user)
    ->where('task.status', $taskStatus)
    ->where('end_date', '<=', date("m/d/Y"))
    ->get();

    return $tasks;
}


/**
 * get Normalize date
 *
 *
 * @return mixed
 */
function getNormalizeDate($date)
{   if(isset($date) && !empty($date)){
        $oldDate = explode("/", $date);
        return $oldDate[1].'-'.$oldDate[0].'-'.$oldDate[2];
    }else{
        return $date;
    }
    
}

/**
 * get Style Priority
 *
 *
 * @return mixed
 */
function getStylePriority($priority)
{   
    if($priority == 'Низкий'){
        return '<p class="text-success">Низкий</p>';
    }elseif($priority == 'Нормальный'){
        return '<p class="text-info">Нормальный</p>';
    }elseif($priority == 'Высокий'){
        return '<p class="text-danger">Высокий</p>';
    }
}

/**
 * get Style Priority
 *
 *
 * @return mixed
 */
function getStyleStatus($status)
{   
    if(1 == $status){
        return '<span class="badge bg-success">В работе</span>';
    }elseif(2 == $status){
        return '<span class="badge bg-warning">Архив</span>';
    }elseif(3 == $status){
        return '<span class="badge bg-danger">Отменен</span>';
    }elseif(4 == $status){
        return '<span class="badge bg-primary">Завершен</span>';
    }

    
}



























