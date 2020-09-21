<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
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
            $divisions = Division::where("name", "like", "%$keyword%")->orderBy('id',"desc")->paginate($perPage);
        } else {
            $divisions = Division::latest()->orderBy('id',"desc")->paginate($perPage);
        }

        return view('pages.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.division.create');
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
            'name'         => 'required|unique:divisions,name',
            'person_name'  => 'required',
            'person_phone' => 'required',
        ]);

        $requestData = $request->all();
        
        $newDivision = Division::create($requestData);

        return redirect('admin/divisions')->with('flash_message', 'Подразделение добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show($division)
    {
        $division = Division::findOrFail($division);

        return view('pages.division.show', compact('division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit($division)
    {
        $division = Division::findOrFail($division);

        return view('pages.division.edit', compact('division'));
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
            'name'         => 'required|unique:divisions,name,' . $id,
            'person_name'  => 'required',
            'person_phone' => 'required',
        ]);

        $requestData = $request->all();
        
        $division = Division::findOrFail($id);
        $division->update($requestData);

        return redirect('admin/divisions')->with('flash_message', 'Подразделение обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy($division)
    {

        Division::destroy($division);

        return redirect('admin/divisions')->with('flash_message', 'Подразделение удалено');
    }
}
