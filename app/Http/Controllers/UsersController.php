<?php

namespace App\Http\Controllers;

use App\Helpers\MailerFactory;
use App\Http\Requests;

use App\User;
use App\Models\Division;
use App\Models\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public function __construct(MailerFactory $mailer)
    {
        $this->middleware('admin:index-list_users|show-view_user', ['except' => ['getProfile', 'getEditProfile', 'postEditProfile']]);
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

        if (!empty($keyword)) {
            $users = User::where('name', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%")->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $parents   = User::all();
        $divisions = Division::all();

        return view('pages.users.create', compact('parents', 'divisions'));
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
        $this->validate($request, [
            'name'    => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required',
            'division_id' => 'required',
            'image'    => 'image|mimes:jpeg,png,jpg,gif'
         ]);

        $requestData = $request->except(['is_profile', '_token']);

        $requestData['password']  = bcrypt($requestData['password']);
        $requestData['is_active'] = isset($requestData['is_active'])?1:0;


        if ($request->hasFile('image')) {
 
            checkDirectory("users");
            $requestData['image'] = uploadFile($request, 'image', public_path('uploads/users'));
        }
 
        if(($count = User::all()->count()) && $count == 0) {
            $requestData['is_admin'] = 1;
        }
        
        User::create($requestData);

        return redirect('admin/users')->with('flash_message', 'Пользователь был добавлен');
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
        $user = User::findOrFail($id);
        $tasks = TaskAssigned::where('user_id', $id)->get();

        return view('pages.users.show', compact('user', 'tasks'));
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
        $user = User::findOrFail($id);
        $divisions = Division::all();

        return view('pages.users.edit', compact('user', 'divisions'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'division_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif'
         ]);

        $requestData = $request->except(['_token']);

        if ($request->hasFile('image')) {
            checkDirectory("users");
            $requestData['image'] = uploadFile($request, 'image', public_path('uploads/users'));
        }
        
        $user = User::findOrFail($id);

        $old_is_active = $user->is_active;
 
        if($user->is_admin == 0) {
            $requestData['is_active'] = isset($requestData['is_active']) ? 1 : 0;
        }

        $user->update($requestData);

        return redirect('admin/users')->with('flash_message', 'Пользователь был обновлен');
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
        User::destroy($id);

        return redirect('admin/users')->with('flash_message', 'Пользователь был удален');
    }

    /**
     * show user profile
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile()
    {
        $user  = User::findOrFail(Auth::user()->id);
        $tasks = TaskAssigned::where('user_id', Auth::user()->id)->get();
 
        return view('pages.users.profile.view', compact('user', 'tasks'));
    }
 
    public function getEditProfile()
    {
        $user = User::findOrFail(Auth::user()->id);
 
        return view('pages.users.profile.edit', compact('user'));
    }
 
    public function postEditProfile(Request $request)
    {
        $id = Auth::user()->id;
 
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif'
        ]);
 
        $requestData = $request->except(['_token']);
 
        if ($request->hasFile('image')) {
            checkDirectory("users");
            $requestData['image'] = uploadFile($request, 'image', public_path('uploads/users'));
        }
 
        if(!empty($requestData['password'])) {
 
            $requestData['password'] = bcrypt($requestData['password']);
        } else {
            unset($requestData['password']);
        }
 
        $user = User::findOrFail($id);
 
        $user->update($requestData);
 
        return redirect('admin/my-profile')->with('flash_message', 'Профайл обновлен!');
    }

    /** Roles **/

    public function getRole($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('pages.users.role', compact('user', 'roles'));
    }

    public function updateRole(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required'
        ]);
 
        $user = User::findOrFail($id);
 
        $old_roles = $user->roles();
 
        $user->syncRoles($request->role_id);       
 
        return redirect('admin/users')->with('flash_message', 'Роль обновлена!');
    }




























}
