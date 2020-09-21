<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin:index-list_projects|create-create_project|show-view_project|edit-edit_project|destroy-delete_project', ['except' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $projects = Project::where("name", "like", "%$keyword%")->orderBy('id',"desc")->paginate($perPage);
        } else {
            $projects = Project::latest()->orderBy('id',"desc")->paginate($perPage);
        }

        return view('pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|unique:divisions,name',
            'division_id' => 'required',
            'description' => 'required',
            'status'      => 'required',
            'person'      => 'required',
        ]);

        $requestData = $request->all();
        
        $role = Project::create($requestData);

        return redirect('admin/projects')->with('flash_message', 'Проект добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $tasks   = Task::where("project_id", $project->id)->get();

        return view('pages.projects.show', compact('project', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit($project)
    {
        $project = Project::findOrFail($project);

        return view('pages.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'        => 'required|unique:projects,name,' . $id,
            'division_id' => 'required',
            'status'      => 'required',
            'person'      => 'required',
        ]);

        $requestData = $request->all();
        
        $project = Project::findOrFail($id);
        $project->update($requestData);

        return redirect('admin/projects')->with('flash_message', 'Проект обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {

        Project::destroy($project);

        return redirect('admin/projects')->with('flash_message', 'Проект удален');
    }
    
}
