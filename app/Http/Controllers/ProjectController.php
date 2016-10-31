<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Http\Requests;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function randomString()
    {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
	$flag = false;

	do {
            for ($i = 0; $i < 10; $i++) {
        	$randstring .= $characters[rand(0, strlen($characters)-1)];
            }

	    if(Project::get()->where('token', '=', $randstring)->all()) {
		$flag = true;
	    } 
	    else {
		$flag = false;
	    }
	} while($flag);

        return $randstring;
    }

    public function store(Request $request)
    {
	if(! strcmp($request->input('project_name'), '프로젝트 이름')) {
	    return response()->json([
                'project_name' => array('프로젝트 이름 입력')
            ], 422);
	} 
	else if(! strcmp($request->input('due_date'), '마감 날짜')) {
	    return response()->json([
                'due_date' => array('마감 날짜 선택')
            ], 422);
	}
	else if(! strcmp($request->input('description'), '프로젝트 내용')) {
	    return response()->json([
                'description' => array('프로젝트 내용 입력')
            ], 422);
	}
	
	$this->validate($request, [
	    'project_name' => 'required|min:4|max:30',
	    'due_date' => 'required|date_format:Y-m-d',
	    'description' => 'required|min:10|max:500',
	]);

	$user = Auth::user();

        $project = new Project;
	$project->name = $request->input('project_name');
	$project->author = $user->user_id;
	$project->members = $user->user_id . '?:';
	$project->description = $request->input('description');
	$project->token = $this->randomString();
	$project->due_date = date('Y-m-d H:i:s', strToTime($request->input('due_date')) + 60 * 60 * 24 - 1);
	$project->save();

	return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
