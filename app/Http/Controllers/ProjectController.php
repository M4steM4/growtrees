<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\User;
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

    private function filterBlankStore(Request $request)
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
	else {
	    return null;
	}
    }

    private function validateStore(Request $request, User $user)
    {
	$this->validate($request, [
            'project_name' => 'required|min:4|max:20',
            'due_date' => 'required|date_format:Y-m-d',
            'description' => 'required|min:10|max:500',
        ]);

	// project project name duplication per one user
	$flag = Project::where('name', '=', $request->input('project_name'))->first();
	if($flag != null) {
	    return response()->json([
                'project_name' => array('중복된 이름')
            ], 422);	
	}
    }

    private function createProject(Request $request, User $user)
    {
	$project = new Project;

        $project->name = $request->input('project_name');
        $project->author = $user->id;
        $project->members = $user->id . 'n';
        $project->description = $request->input('description');
        $project->token = $this->randomString();
        $project->due_date = date('Y-m-d H:i:s', strToTime($request->input('due_date')) + 60 * 60 * 24 - 1);

        $project->save();
    }

    public function store(Request $request)
    {
	$response = $this->filterBlankStore($request);
	if($response != null) { 
		return $response; 
	}

	$user = Auth::user();

	$response = $this->validateStore($request, $user);
	if($response != null) {
		return $response;
	}

	$this->createProject($request, $user);

	return 'success';
    }

    // project_list/{str}
    public function getList($str) {
	$items = Project::select(['name', 'author'])->where('name', 'like', $str . '%')->get();
	return $items;
    }
    // project_info/{projectName}
    public function getInfo($projectName) {
	$info = Project::select(['name', 'description', 'author', 'members'])
			->where('name', '=', $projectName)
			->first();
	
	//$members = $info['members'];
	//$info['members'] = count(explode('n', $members))-1;

	return $info;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
	$this->authorize('access', $project);
	$user = Auth::user();
    	return view('project', compact('user'));
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
