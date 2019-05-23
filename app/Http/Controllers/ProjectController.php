<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\ProjectsXUsers;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        $this->middleware('numberuri',['only' => 'show']);
        $this->middleware('loggedin');
     }
    public function index()
    {
        return redirect('dashboard');
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
    public function store(Request $request)
    {
        $project = new Project;
        $task = new Task;
        $pxu = new ProjectsXUsers;

        $project->project_name = $request['inp-project-title'];
        $project->project_detail = $request['inp-project-desc'];
        $project->project_start_day = $request['inp-project-start'];
        $project->project_end_day = $request['inp-project-end'];
        // $project->project_budget = $request['inp-project-budget'];
        $project->project_manager_id = Auth::user()->user_id;
        $project->save();

        $pxu->project_id = $project->project_id;
        $pxu->user_id = $project->project_manager_id;
        $pxu->role = 1;
        $pxu->save();

        return redirect(route('dashboard'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $tasks = ProjectsXUsers::with('tasks')->where('project_id',$id)->get();
        $pxu = ProjectsXUsers::where('project_id',$id);
        $userIds = getJoinedUserIds($id);
        $users = User::find($userIds);
        $manager = $users->where('user_id','=',$project->project_manager_id);
        return view('project',[
            'projectObj' => $project,
            'users' => $users,
            'manager' => $manager[0],
            'pxu' => $pxu,
            'tasks' => $tasks,
            'currUser' => Auth::user()
            ]);
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
        $validator = $request->validate([
            'project_name' =>'required',
            'project_detail' => 'required',
        ]);
        $project = Project::find($id);
        $project->project_name = $request['project_name'];
        $project->project_detail = $request['project_detail'];
        $project->project_end_day = $request['project_end_day'];
        $project->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pxu_ids = ProjectsXUsers::where('project_id',$id)->get('pxu_id')->implode('pxu_id',',');
        // return ($pxu_ids);
        Task::where('pxu_id',$pxu_ids)->delete();
        ProjectsXUsers::find($pxu_ids)->delete();
        Project::find($id)->delete();
        return redirect()->route('dashboard');
    }

    public function searchUser(Request $request)
    {
        $keyword = $request->input('keyword');
        $project_id = $request->input('id');
        $keyword = trim(strtolower($keyword));
        $joinedUserIds = getJoinedUserIds($project_id);

        $users = User::whereNotIn('user_id',$joinedUserIds)->whereRaw('LOWER(user_fullname) LIKE ?', "%${keyword}%")->get();
        return ($users);
    }

}
