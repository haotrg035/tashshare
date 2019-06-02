@extends('master')
@section('ContentArea')
    {{-- @php
        use App\ProjectsXUsers;
        echo dd(ProjectsXUsers::with('tasks')->get());
    @endphp --}}
    <div id="page-content-area" class="h-100 container p-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 bg-white mt-2 p-2 border shadow-sm">
                    <h3 id="project-detail-header" class="border-bottom d-flex justify-content-between">
                        <span id="project-detail-title">{{$projectObj->project_name}}</span>
                        @if ($projectObj->project_manager_id == $currUser->user_id)
                            <span>
                        <a data-toggle="modal" href="#modal-edit-project-detail" id="btn-project-detail-edit" class="">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0)" id="delProjectBtn" class="btn-project-detail-delete ml-2"><i
                                    class="fa fa-trash text-danger" alt="Xóa dự án" aria-hidden="true"></i></a>
                    </span>
                        @endif
                    </h3>
                    <div id="project-detail-content" class="">
                        <div id="project-intro" class="border-bottom pb-2">
                            {{$projectObj->project_detail}}
                        </div>
                        <div id="project-info">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i><strong
                                            class="d-md-inline"> Bắt đầu:</strong> <span
                                            id="project-detail-start">{{date_format(date_create($projectObj->project_start_day),'d/m/Y')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i><strong
                                            class="d-md-inline"> Hạn nộp:</strong> <span
                                            id="project-detail-end">{{date_format(date_create($projectObj->project_end_day),'d/m/Y')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-dollar"></i><strong class="d-md-inline"> Ngân Sách:</strong> N/A
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pl-0 pl-md-2 pr-0">
                    <div class="mt-2 bg-white shadow-sm border ">
                        <h3 class="border-bottom p-2 d-flex justify-content-between">
                            <span>Nhân sự</span>
                            <a href="#modal-add-employee" data-toggle="modal">
                                <i class="fa fa-user-plus text-success" aria-hidden="true"></i>
                            </a>
                        </h3>
                        <!-- Title -->
                        <div id="employees-area" class="list-group list-group-flush"
                             style="min-height:190px; max-height:190px; overflow: auto;">
                            @foreach ($pxus as $pxu)
                                <a href="https://www.google.com"
                                   data-userid="{{$pxu->user->user_id}}"
                                   class="d-flex justify-content-between align-items-center mb-1 list-group-item list-group-item-action">
                                    <div class="media action">
                                        <span class="d-flex justify-content-start">
                                            <img width="30"
                                                 src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png"
                                                 alt="">
                                            <div class="media-body d-flex align-items-center">
                                                <div class="h2 m-0">{{$pxu->user->user_fullname}}</div>
                                            </div>
                                        </span>
                                    </div>

                                    @if ($pxu->role == 1)
                                        <i class="fa fa-user-circle h3 text-primary" aria-hidden="true"></i>
                                    @endif
                                </a>

                                <!-- !End Employee -->
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col bg-white mt-2 shadow-sm border px-2">
                    <h3 class="border-bottom p-2 d-flex justify-content-between">
                        <span>Công việc</span>
                        <a id="btn-modal-add-task" href="" data-toggle="modal">
                            <i class="fa fa-plus-circle text-success" aria-hidden="true"></i>
                        </a>
                    </h3>

                    <div id="tasks-area" class="row py-2">
                        @foreach($tasks as $task)
                            <div class="col-md-3 mb-2">
                                <a href="javascript:void(0)" data-task-id="{{$task['task_id']}}" data-task-pxu="{{$task['pxu_id']}}" class=""
                                   onclick="openTaskToEdit(this)">
                                    <div class="card shadow-sm">
                                        <div class="card-body p-2 {{$task['process'] == 100 ? 'bg-success' : 'bg-secondary'}} rounded">{{-- task's background color --}}
                                            <div class="card-title border-bottom bg-white p-1 rounded mb-0">
                                                <div class="border-bottom overflow-hidden"
                                                     style="max-height:22px;white-space: nowrap;overflow-y:hidden;text-overflow:ellipsis;">
                                                    <b class="task-title">{{$task['task_name']}}</b>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="task-user">
                                                        <img class="task-user-img rounded"
                                                             src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png"
                                                             alt="" width="18px" height="18px">
                                                    </div>
                                                    <span>
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                        <p class="d-inline task-deadline">{{converDate($task['task_end'])}}</p>
                                                    </span>
                                                </div>
                                            </div>
                                            <ul class="list-group mt-2">
{{--                                                <li class=" py-2 d-none" style="list-style-type: none">--}}
{{--                                                    <div class="progress border">--}}
{{--                                                        <div class="progress-bar bg-success" role="progressbar"--}}
{{--                                                             style="width: {{$task['process']}}%;"--}}
{{--                                                             aria-valuenow="{{$task['process']}}%" aria-valuemin="0"--}}
{{--                                                             aria-valuemax="100">{{$task['process']}}%--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
                                                @if(!empty($subtasks[$task['task_id']]))
                                                    @foreach($subtasks[$task['task_id']] as $subtask)
                                                        <li class="list-group-item" data-subtask-id="{{$subtask['sub_id']}}">{{$subtask['sub_name']}}</li>
                                                    @endforeach
{{--                                                <li class="list-group-item "><span--}}
{{--                                                            class="badge badge-success">&#10004;</span> Active item--}}
{{--                                                </li>--}}
{{--                                                <li class="list-group-item">Item</li>--}}
{{--                                                <li class="list-group-item">Disabled item</li>--}}
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div><!-- project info right col -->

        <div class="modal fade" id="modal-edit-project-detail" tabindex="-1" role="dialog"
             aria-labelledby="Chỉnh Sửa Project" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh Sửa Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('project.update', ['id'=>$projectObj->project_id]) }}"
                              id="form-project-detail-edit">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="inp-project-title">Tên Dự Án</label>
                                <input type="text" name="project_name" id="inp-project-title" class="form-control"
                                       placeholder="" aria-describedby="helpId" required>
                            </div>
                            <div class="form-group">
                                <label for="inp-project-desc">Mô tả</label>
                                <textarea class="form-control" name="project_detail" id="inp-project-desc" rows="3"
                                          required></textarea>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="inp-project-detail-start">Ngày Bắt Đầu</label>
                                        <input type="date" class="form-control" disabled name="project_start_day"
                                               id="inp-project-detail-start" aria-describedby="helpId" placeholder="">
                                        <small id="helpId" class="form-text text-muted">Mặc định là ngày khởi tạo dự
                                            án
                                        </small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="inp-project-detail-end">Hạn Hoàn Thành</label>
                                        <input type="date" class="form-control" name="project_end_day"
                                               id="inp-project-detail-end" aria-describedby="helpId" placeholder=""
                                               required>
                                        <small id="helpId" class="form-text text-muted">Vui lòng chọn thời hạn cho dự
                                            án
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3 d-none">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">VNĐ</span>
                                </div>
                                <input type="number" step="1000" spellcheck="true" name="inp-project-detail-budget"
                                       id="inp-project-detail-budget" class="form-control" placeholder=""
                                       aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                <input type="submit" class="btn btn-success" value="Lưu"/>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div> <!-- Edit project Modal -->

        <div class="modal fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-labelledby="Thêm nhân sự"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Thêm nhân sự</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{route('project.adduser')}}" method="POST" id="fm-add-task" class="px-3">
                        @csrf
                        <div class="input-group pt-2">
                            <input type="text" name="inp-user-search" id="inp-user-search" class="form-control"
                                   placeholder="Tìm người dùng...">
                        </div>
                        <div id="employees-desk" class="row py-2" style="max-height: 300px; overflow-y: auto">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input id="btn-add-employee" type="button" class="btn btn-success" value="Thêm"/>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Modal add employee -->

        <div class="modal fade" id="modal-add-task" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-light">
                        <h5 class="modal-title">Thêm công việc</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fm-add-task" action="{{route('project.addtask')}}" method="post">
                            @csrf
                            <input type="hidden" name="project_id" value="{{$projectObj->project_id}}">
                            <input type="hidden" name="task_id" value="">
                            <div class="">
                                <div class="form-group">
                                    <label for="task_name">Tên công việc</label>
                                    <input type="text" class="form-control" name="task_name" id="task_name"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-6">
                                   <div class="form-group">
                                       <label for="task_state">Trạng thái</label>
                                       <select class="custom-select" name="task_state" id="task_state">
                                           <option value="0" selected>Đang thực hiện</option>
                                           <option value="1">Hoàn thành</option>
                                       </select>
                                   </div>
                               </div>
                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="task_deadline">Thời hạn</label>
                                        <input type="date" class="form-control pl-1 pr-0" name="task_deadline" id="task_deadline" required>
                                    </div>
                                </div>

                            </div>
                            <div id="form-group-employees" class="form-group border-bottom pb-3">
                                <label for="pxu_id_name">Người phụ trách</label>
                                <a id="collapse-tasks" class="" data-toggle="collapse" href="#available-employees"
                                   aria-expanded="false"
                                   aria-controls="avalable-employees">
                                    <input type="text" class="form-control" name="pxu_id_name" id="pxu_id_name" readonly
                                           placeholder="Chọn nhân viên" required>
                                    <input type="hidden" class="form-control" name="pxu_id" id="pxu_id"
                                           aria-describedby="helpId" placeholder="" required>
                                </a>
                                <div class="collapse px-2" id="available-employees">
                                    <div id="list-available-employees" class="row mt-2">

                                        {{-- End employee --}}
                                    </div>
                                </div>{{-- end available employees area --}}
                            </div>
                            <div id="task-progress" class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                     aria-valuemin="0" aria-valuemax="100">25%
                                </div>
                            </div>
                            <div id="task-subtasks" class="form-group">
                                <label for="task_name">Mục tiêu</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="sub_task_name" id="sub_task_name" class="form-control"
                                           placeholder="Thêm mục tiêu">
                                    <div class="input-group-append">
                                        <a class="btn btn-success text-light" id="btn-add-subtask">Thêm</a>
                                    </div>
                                </div>
                            </div>
                            <ul id="area-add-tasks" class="list-group border rounded">
                                {{--                                <li class="list-group-item border-0 d-flex justify-content-between">--}}
                                {{--                                    <div class="custom-control custom-checkbox">--}}
                                {{--                                        <input type="checkbox" class="custom-control-input" name="task_id_1"--}}
                                {{--                                               id="task_id_1" value="1">--}}
                                {{--                                        <label class="subtask-content custom-control-label" for="task_id_1">Check this custom--}}
                                {{--                                            checkbox</label>--}}
                                {{--                                    </div>--}}
                                {{--                                    <a href="#" class="badge badge-danger p-2">X</a>--}}
                                {{--                                </li>--}}

                            </ul>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                <button id="btn-add-task" type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>{{-- Modal add task --}}
        <div class="modal fade" id="modal-edit-task" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-light">
                        <h5 class="modal-title">Cập nhật công việc</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fm-edit-task" action="{{route('project.edittask')}}" method="post">
                            @csrf
                            <input type="hidden" name="project_id" value="{{$projectObj->project_id}}">
                            <input type="hidden" name="task_id" value="">
                            <div class="">
                                <div class="form-group">
                                    <label for="task_name">Tên công việc</label>
                                    <input type="text" class="form-control" name="task_name" id="edit_task_name"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="task_state">Trạng thái</label>
                                        <select class="custom-select" name="task_state" id="edit_task_state">
                                            <option value="0" selected>Đang thực hiện</option>
                                            <option value="1">Hoàn thành</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="task_deadline">Thời hạn</label>
                                        <input type="date" class="form-control pl-1 pr-0" name="task_deadline" id="edit_task_deadline" required>
                                    </div>
                                </div>

                            </div>
                            <div id="edit_form-group-employees" class="form-group border-bottom pb-3">
                                <label for="pxu_id_name">Người phụ trách</label>
                                <a id="edit_collapse-tasks" class="" data-toggle="collapse" href="#edit_available-employees"
                                   aria-expanded="false"
                                   aria-controls="avalable-employees">
                                    <input type="text" class="form-control" name="pxu_id_name" id="edit_pxu_id_name" readonly
                                           placeholder="Chọn nhân viên" required>
                                    <input type="hidden" class="form-control" name="pxu_id" id="edit_pxu_id"
                                           aria-describedby="helpId" placeholder="" required>
                                </a>
                                <div class="collapse px-2" id="edit_available-employees">
                                    <div id="edit_list-available-employees" class="row mt-2">

                                        {{-- End employee --}}
                                    </div>
                                </div>{{-- end available employees area --}}
                            </div>
                            <div edit_="edit_task-progress" class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                     aria-valuemin="0" aria-valuemax="100">25%
                                </div>
                            </div>
                            <div id="edit_task-subtasks" class="form-group">
                                <label for="task_name">Mục tiêu</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="sub_task_name" id="edit_sub_task_name" class="form-control"
                                           placeholder="Thêm mục tiêu">
                                    <div class="input-group-append">
                                        <a class="btn btn-success text-light" id="edit_btn-add-subtask">Thêm</a>
                                    </div>
                                </div>
                            </div>
                            <ul id="area-add-tasks" class="list-group border rounded">
                                {{--                                <li class="list-group-item border-0 d-flex justify-content-between">--}}
                                {{--                                    <div class="custom-control custom-checkbox">--}}
                                {{--                                        <input type="checkbox" class="custom-control-input" name="task_id_1"--}}
                                {{--                                               id="task_id_1" value="1">--}}
                                {{--                                        <label class="subtask-content custom-control-label" for="task_id_1">Check this custom--}}
                                {{--                                            checkbox</label>--}}
                                {{--                                    </div>--}}
                                {{--                                    <a href="#" class="badge badge-danger p-2">X</a>--}}
                                {{--                                </li>--}}

                            </ul>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                <button id="btn-edit-task" type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>{{-- Modal edit task --}}

        <form method="POST" action="{{ route('project.destroy', ['id'=>$projectObj->project_id]) }}"
              id="fm-deleteProject">
            @csrf
            @method('DELETE')
        </form> {{-- form delete project --}}
    </div>
@endsection
@section('private-js')
    <script>
        $(document).ready(function () {
            let elemToHide = $('#task-progress,#task-subtasks,#area-add-tasks');
            let joinedUsers = {};
            window.addChosenClass = (element) => {
                $(element).toggleClass('chosen-user');
            };
            window.removeSubTask = function (ele) {
                $(ele).parent().remove();
            };
            window.choseTasksUser = (elem) => {
                $('#pxu_id_name, #pxu_id_name').val($(elem).find('span').text());
                $('#pxu_id, #edit_pxu_id').val($(elem).find('input').val());
                $('#available-employees, #edit_available-employees').collapse('hide');
            };
            window.openTaskToEdit = (elem) => {
                $('#edit_task_name').val($(elem).find('.task-title').text());
                $('#edit_task_deadline').val(LocalDateToStandard($(elem).find('.task-deadline').text()));
                let pxu = $(elem).attr('data-task-pxu');
                let username = '';
                for (let i = 0; i <joinedUsers.length; i++) {
                    if (joinedUsers[i].pxu_id == pxu){
                        username = joinedUsers[i].user.user_fullname;
                        break;
                    }
                }
                $('#edit_pxu_id_name').val(username);
                $('#edit_pxu_id').val(pxu);
                let progress =$(elem).find('.progress .progress-bar').text();
                $('#edit_task-progress .progress-bar').css('width',progress).text(progress);
                $('#fm-edit-task input[name="task_id"]').val($(elem).attr('data-task-id'));
                $('#modal-edit-task').modal('show');
            };

            function getUsersFromServer() {
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: "{{route('project.getuser')}}",
                    data: {'project_id': '{{$projectObj->project_id}}'},
                    dataType: 'json',
                    success: function (respone) {
                        joinedUsers = respone;
                    }
                })
            }

            async function getUsers() {
                await getUsersFromServer();
                $('#list-available-employees,#edit_list-available-employees').html('');
                for (const pxu of joinedUsers) {
                    $('#list-available-employees,#edit_list-available-employees').append('<div class="col-6 mb-2 px-2" onclick="choseTasksUser(this)">'
                        + '<a href="javascript:void(0)"  class="list-group-item list-group-item-action">'
                        + '<span class="available-employees-name">' + pxu.user.user_fullname + '</span>'
                        + '<input type="hidden" value="' + pxu.user.user_id + '" class="available-employees-id">'
                        + '</a>'
                        + '</div>'
                    )
                }
            }

            $('#btn-modal-add-task').click(function (e) {
                if (!elemToHide.hasClass('d-none')) {
                    elemToHide.addClass('d-none');
                }
                $('#pxu_id_name, #pxu_id').val('');
                $('#modal-add-task').modal('show');
            });
            $('#modal-edit-project-detail').on('show.bs.modal', (e) => {
                $('#inp-project-title').val($('#project-detail-title').text());
                $('#inp-project-desc').val($('#project-intro').text().trim());
                $('#inp-project-detail-start').val("{{$projectObj->project_start_day}}");
                $('#inp-project-detail-end').val("{{$projectObj->project_end_day}}");
            });
            $('#delProjectBtn').click(function (e) {
                e.preventDefault();
                if (confirm('Bạn có chắc muốn xóa Project này?')) {
                    $('#fm-deleteProject').submit();
                }
            });
            let UserSearchData = {
                id: "{{$projectObj->project_id}}"
            };
            $('#inp-user-search').keyup(function (e) {
                UserSearchData.keyword = $('#inp-user-search').val();
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    type: "POST",
                    url: "{{route('project.search')}}",
                    data: UserSearchData,
                    dataType: "json",
                    success: function (response) {
                        $('#employees-desk').html('');
                        if (response.length > 0) {
                            for (const user of response) {
                                $('#employees-desk').append(
                                    '<a id="avalilableUser_' + user.user_id + '" href="javascript:void(0)" onClick="addChosenClass(this)" class="col-12 col-md-4 pl-4 py-2">'
                                    + '<div class="row text-left hover-shadow">'
                                    + '<img height="60px" height="60px" class="col-3 p-1 rounded" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png" alt="">'
                                    + '<div class="col-9">'
                                    + '<h5 class="h5">' + user.user_fullname + '</h5>'
                                    + '<p class="">' + user.user_email + '</p>'
                                    + '</div>'
                                    + '</div>'
                                    + '</a>');
                            }
                        }
                    }
                });
            });
            $('#list-available-employees > div > a').each((index, elem) => {
                $(elem).click(function (e) {
                    $('#pxu_id_name').val($(elem).find('span').text());
                    $('#pxu_id').val($(elem).find('input').val());
                    $('#available-employees').collapse('toggle');
                });
            });


            $('#btn-add-subtask').click(function (e) {
                e.preventDefault();
                let subTaskName = $('#sub_task_name').val().trim();
                if (subTaskName != '') {
                    $('#area-add-tasks').append('<li  class="sub-task list-group-item border-0 d-flex justify-content-between">'
                        + '<div class="subtask-content">' + subTaskName + '</div>'
                        + '<a href="#" onclick="removeSubTask(this)" class="badge badge-danger d-flex align-items-center p-2">X</a>'
                        + '</li>'
                    );
                }

            });

            $('#btn-add-employee').click(function (e) {
                let data = {
                    userIds: [],
                    project_id: '{{$projectObj->project_id}}'
                };
                $('#employees-desk').find('.chosen-user').each((key, value) => {
                    data.userIds.push($(value).attr('id').split('_')[1]);
                });
                if (data.userIds.length > 0) {
                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{route('project.adduser')}}",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            getUsers();
                            $('#employees-area').html('');
                            for (const pxu of response) {
                                $('#employees-area').append('<a href="https://www.google.com" data-userid="' + pxu.user.user_id + '" class="d-flex justify-content-between align-items-center mb-1 list-group-item list-group-item-action">'
                                    + '<div class="media action">'
                                    + '<span class="d-flex justify-content-start">'
                                    + '<img width="30" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png">'
                                    + '<div class="media-body d-flex align-items-center">'
                                    + '<div class="h2 m-0">' + pxu.user.user_fullname + '</div>'
                                    + '</div>'
                                    + '</span>'
                                    + '</div>'
                                    + ((pxu.role > 0) ? '<i class="fa fa-user-circle h3 text-primary" aria-hidden="true"></i>' : '')
                                    + '</a>'
                                )
                            }
                            $('#inp-user-search').val('');
                            $('#employees-desk').html('');
                            $('#modal-add-employee').modal('hide');
                        }
                    });
                } else {
                    alert('Vui lòng chọn người dùng cần thêm!');
                }
            });
            getUsers();
        });
    </script>
@endsection