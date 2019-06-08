<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubTask;
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
        $this->middleware('numberuri', ['only' => 'show']);
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
     * @param \Illuminate\Http\Request $request
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $tasks = Project::with('tasks')->find($id)->getRelations()['tasks']->toArray();
        $subtasks = [];
        usort($tasks, function ($a, $b) {
            $time1 = strtotime($a['task_end']);
            $time2 = strtotime($b['task_end']);
            return ($time1 - $time2);
        });
        foreach ($tasks as $task) {
            $subtasks[$task['task_id']] = SubTask::where('task_id', $task['task_id'])->get()->toArray();
        }
        $pxus = ProjectsXUsers::with('user')->get();
        $manager_pxu_id = ProjectsXUsers::where([['project_id','=',$id],['role','=',1]])->get('pxu_id')->toArray();
        $curr_pxu_id = ProjectsXUsers::where('user_id',Auth::user()->user_id)->get('pxu_id')->toArray();
        return view('project', [
            'projectObj' => $project,
            'pxus' => $pxus,
            'tasks' => $tasks,
            'subtasks' => $subtasks,
            'currUser' => Auth::user(),
            'managerPXU'=>$manager_pxu_id[0]['pxu_id'],
            'currPXU' => $curr_pxu_id[0]['pxu_id']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'project_name' => 'required',
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pxu_ids = ProjectsXUsers::where('project_id', $id)->get('pxu_id')->implode('pxu_id', ',');
        // return ($pxu_ids);
        Task::where('pxu_id', $pxu_ids)->delete();
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

        $users = User::whereNotIn('user_id', $joinedUserIds)->whereRaw('LOWER(user_fullname) LIKE ?', "%${keyword}%")->get();
        return ($users);
    }

    public function addUser(Request $request)
    {
        foreach ($request->input('userIds') as $userId) {
            if (!(ProjectsXUsers::where('user_id', $userId)->count() > 0)) {
                $pxu = new ProjectsXUsers();
                $pxu->project_id = $request->input('project_id');
                $pxu->user_id = $userId;
                $pxu->role = 0;
                $pxu->save();
            }
        }
        $joinedUsers = ProjectsXUsers::with('user')->where('project_id', $request->input('project_id'))->get();
        return $joinedUsers;
    }

    public function getProjectsUsers(Request $request)
    {
//        $userIds = ProjectsXUsers::where('project_id',$request->input('project_id'))->get('user_id')->toArray();
        $joinedUsers = ProjectsXUsers::with('user')->where('project_id', $request->input('project_id'))->get();
        return $joinedUsers;
    }

    public function addTask(Request $request)
    {
        $data = $request->all();
        $newtask = new Task();
        $newtask->pxu_id = $data['pxu_id'];
        $newtask->task_name = $data['task_name'];
        $newtask->task_end = $data['task_deadline'];
        $newtask->process = $data['task_state'] == 1 ? 100 : 0;

        $newtask->save();
        $this->updateProjectProcess($data['project_id']);

        return redirect()->back();
    }

    public function editTask(Request $request)
    {
        $data = $request->all();
        $task = Task::find($data['task_id']);
        $task->task_name = $data['task_name'];
        $task->task_end = $data['task_deadline'];
        $task->pxu_id = $data['pxu_id'];
        $task->process = $data['task_state'] == 1 ? 100 : 0;
        $task->save();
        $old_sub_tasks = SubTask::where('task_id', $task->task_id)->get();
        if (!empty($data['old_sub_task'])) {
            foreach ($old_sub_tasks as $sub_task) {
                if (!in_array($sub_task->sub_id, array_keys($data['old_sub_task']))) {
                    $sub_task->delete();
                } else if (in_array($sub_task->sub_id, array_keys($data['old_sub_task']))) {
                    $sub_task->sub_name = $data['old_sub_task'][$sub_task['sub_id']];
                    $sub_task->save();
                }
            }
        } else if (!empty($old_sub_tasks->toArray())) {
            SubTask::where('task_id', $task->task_id)->delete();
        }
        if (!empty($data['new_sub_tasks'])) {
            foreach ($data['new_sub_tasks'] as $newsubtask) {
                $stask = new SubTask();
                $stask->task_id = $task->task_id;
                $stask->sub_name = $newsubtask;
                $stask->sub_state = 1;
                $stask->save();
            }
        }
        $this->updateProjectProcess($data['project_id']);

//        update project process
        return redirect()->back();
    }
    public function delTask(Request $request){
        $data = $request->all();
        SubTask::where('task_id',$data['task_id'])->delete();
        Task::find($data['task_id'])->delete();
        $this->updateProjectProcess($data['project_id']);
        return $request->all();
    }
    public function delUser(Request $request){
        $data = $request->all();
        $pxu = ProjectsXUsers::where('user_id',$data['user_id'])->get('pxu_id')->toArray();
        $task = Task::where('pxu_id',$pxu[0])->get('task_id')->toArray();
        SubTask::whereIn('task_id',$task)->delete();
        Task::where('pxu_id',$pxu[0])->delete();
        ProjectsXUsers::where('user_id',$data['user_id'])->delete();
        return redirect()->back();
    }
    private function updateProjectProcess($id){
        $pxus = ProjectsXUsers::where('project_id',$id)->get('pxu_id')->toArray();
        $total = Task::whereIn('pxu_id',$pxus)->count();
        $completed = Task::whereIn('pxu_id',$pxus)->where('process',100)->count();
        $result = floor(($completed/($total))*100);
        $project = Project::find($id);
        $project->project_process = $result;
        $project->save();
    }
}
