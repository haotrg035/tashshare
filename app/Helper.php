<?php
    use App\Task;

    function converDate($YMDdate)
    {
        $date = date_create($YMDdate);
        return date_format($date,"d/m/Y");
    }

    /**
     * Hàm dùng để lấy danh sách id của các project mà một user đã tham gia
     *
     * @param String $user_id
     * @return array
     */
    function getJoinedProjectIds($user_id)
    {
        $joinedProjectIds = Task::where('user_id','=',$user_id)->get('project_id')->implode('project_id',',');
        return explode(',',$joinedProjectIds);
    }

     /**
     * Hàm dùng để lấy danh sách id của các user đã tham gia project
     *
     * @param String $project_id
     * @return array
     */
    function getJoinedUserIds($project_id)
    {
        $joinedUserIds = Task::where('project_id','=',$project_id)->get('user_id')->implode('user_id',',');
        return explode(',',$joinedUserIds);
    }

    /**
     * Trả về các các user tên có liên quan đến keyword và không nằm trong project
     *
     * @param String $keyword
     * @return void
     */
    function searchUsersByName($project_id = null, $keyword = null)
    {
        // $project = Project::find($project_id);

    }
?>
