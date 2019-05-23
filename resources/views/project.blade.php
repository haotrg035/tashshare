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
                        <a href="javascript:void(0)" id="delProjectBtn" class="btn-project-detail-delete ml-2"><i class="fa fa-trash text-danger" alt="Xóa dự án" aria-hidden="true"></i></a>
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
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i><strong class="d-md-inline"> Bắt đầu:</strong> <span id="project-detail-start">{{date_format(date_create($projectObj->project_start_day),'d/m/Y')}}</span>
                            </li>
                            <li class="list-group-item">
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i><strong class="d-md-inline"> Hạn nộp:</strong> <span id="project-detail-end">{{date_format(date_create($projectObj->project_end_day),'d/m/Y')}}</span>
                            </li>
                            <li class="list-group-item">
                            <i class="fa fa-dollar"></i><strong class="d-md-inline"> Ngân Sách:</strong> N/A
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pl-0 pl-md-2 pr-0" >
                <div class="mt-2 bg-white shadow-sm border ">
                    <h3 class="border-bottom p-2 d-flex justify-content-between">
                        <span>Nhân sự</span>
                        <a href="#modal-add-employee" data-toggle="modal">
                            <i class="fa fa-user-plus text-success" aria-hidden="true"></i>
                        </a>
                    </h3>
                    <!-- Title -->
                    <div class="list-group list-group-flush" style="min-height:190px; max-height:190px; overflow: auto;">
                        @for ($i = 0; $i < count($users); $i++)
                        @php
                            $pxu = ($pxu->where('user_id',$users[$i]->user_id)->get())[0];
                        @endphp

                        <a href="https://www.google.com" class="d-flex justify-content-between align-items-center mb-1 list-group-item list-group-item-action">
                            <div class="media action">
                                <span class="d-flex justify-content-start">
                                    <img width="30" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png" alt="">
                                    <div class="media-body d-flex align-items-center">
                                        <div class="h2 m-0">{{$users[$i]->user_fullname}}</div>
                                    </div>
                                </span>
                            </div>
                            @if ($pxu->role == 1)
                                <i class="fa fa-user-circle h3 text-primary" aria-hidden="true"></i>
                            @endif
                        </a>

                        <!-- !End Employee -->
                        @endfor
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col bg-white mt-2 shadow-sm border px-2">
                <h3 class="border-bottom p-2 d-flex justify-content-between">
                    <span>Công việc</span>
                    <a href="#modal-add-task" data-toggle="modal">
                        <i class="fa fa-plus-circle text-success"  aria-hidden="true"></i>

                    </a>
                </h3>
                <div id="tasks-area" class="row py-2">
                    <div class="col-md-3 mb-2">
                        <a href="#" class="">
                            <div class="card shadow-sm">
                                <div class="card-body p-2 bg-primary rounded">{{-- task's background color --}}
                                    <div class="card-title border-bottom bg-white p-1 rounded">
                                        <div class="border-bottom overflow-hidden" style="max-height:22px;white-space: nowrap;overflow-y:hidden;text-overflow:ellipsis;">
                                            <b class="task-title ">Chuẩn bị tài liệu chuẩn bị tài liệu</b>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <img class="task-user-img rounded" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png" alt="" width="18px" height="18px">
                                            <span>
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                <p class="d-inline">27/03/2019</p>
                                            </span>
                                        </div>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 33%;"
                                                    aria-valuenow="33%" aria-valuemin="0" aria-valuemax="100">33%</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item "><span class="badge badge-success">&#10004;</span> Active item</li>
                                        <li class="list-group-item">Item</li>
                                        <li class="list-group-item">Disabled item</li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- project info right col -->

    <div class="modal fade" id="modal-edit-project-detail" tabindex="-1" role="dialog" aria-labelledby="Chỉnh Sửa Project" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh Sửa Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('project.update', ['id'=>$projectObj->project_id]) }}" id="form-project-detail-edit">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="inp-project-title">Tên Dự Án</label>
                            <input type="text" name="project_name" id="inp-project-title" class="form-control" placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <label for="inp-project-desc">Mô tả</label>
                            <textarea class="form-control" name="project_detail" id="inp-project-desc" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inp-project-detail-start">Ngày Bắt Đầu</label>
                                    <input type="date" class="form-control" disabled name="project_start_day" id="inp-project-detail-start" aria-describedby="helpId" placeholder="">
                                    <small id="helpId" class="form-text text-muted">Mặc định là ngày khởi tạo dự án</small>
                                    </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inp-project-detail-end">Hạn Hoàn Thành</label>
                                    <input type="date" class="form-control" name="project_end_day" id="inp-project-detail-end" aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Vui lòng chọn thời hạn cho dự án</small>
                                    </div>
                            </div>
                        </div>
                        <div class="input-group mb-3 d-none">
                                <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">VNĐ</span>
                                </div>
                            <input type="number" step="1000" spellcheck="true" name="inp-project-detail-budget" id="inp-project-detail-budget" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input type="submit" class="btn btn-success" value="Lưu" />
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> <!-- Edit project Modal -->

    <div class="modal fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-labelledby="Thêm nhân sự" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Thêm nhân sự</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <form action="#" method="POST" id="fm-add-task" class="px-3">
                    @csrf
                    <div class="input-group pt-2">
                        <input type="text" name="inp-user-search" id="inp-user-search" class="form-control" placeholder="Tìm người dùng...">
                    </div>
                    <div id="employees-desk" class="row py-2" style="max-height: 300px; overflow-y: auto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <input type="submit" class="btn btn-success" value="Thêm"/>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Modal add employee -->

    <div class="modal fade" id="modal-add-task" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title">Thêm công việc</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-7 col-md-8 pr-1">
                                <div class="form-group">
                                    <label for="task_name">Tên công việc</label>
                                    <input type="text" class="form-control" name="task_name" id="task_name">
                                </div>
                            </div>
                            <div class="col-5 col-md-4 pl-0">
                                <label for="task_deadline">Thời hạn</label>
                                <input type="date" class="form-control pl-1 pr-0" name="task_deadline" id="task_deadline">
                            </div>
                        </div>
                        <div id="form-group-employees" class="form-group border-bottom pb-3">
                            <label for="pxu_id_name">Nhân viên phụ trách</label>
                            <a class="" data-toggle="collapse" href="#available-employees" aria-expanded="false" aria-controls="avalable-employees">
                                <input type="text" class="form-control" name="pxu_id_name" id="pxu_id_name" readonly placeholder="Chọn nhân viên">
                                <input type="hidden" class="form-control" name="pxu_id" id="pxu_id" aria-describedby="helpId" placeholder="">
                            </a>
                            <div class="collapse px-2" id="available-employees">
                                <div class="row mt-2">
                                    <div class="col-6 mb-2 px-2">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <span class="available-employees-name">Nguyễn Văn A</span>
                                            <input type="hidden" value="1" class="available-employees-id">
                                        </a>
                                    </div>
                                    <div class="col-6 mb-2 px-2">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <span class="available-employees-name">Nguyễn Văn B</span>
                                            <input type="hidden" value="2" class="available-employees-id">
                                        </a>
                                    </div>
                                    <div class="col-6 mb-2 px-2">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <span class="available-employees-name">Nguyễn Thị C</span>
                                            <input type="hidden" value="3" class="available-employees-id">
                                        </a>
                                    </div>
                                    <div class="col-6 mb-2 px-2">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <span class="available-employees-name">Nguyễn Văn D</span>
                                            <input type="hidden" value="4" class="available-employees-id">
                                        </a>
                                    </div>
                                    {{-- End employee --}}
                                </div>
                            </div>{{-- end available employees area --}}
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                        <div class="form-group">
                            <label for="task_name">Mục tiêu</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="task_name" id="task_name" class="form-control" placeholder="Thêm mục tiêu">
                                <div class="input-group-append">
                                    <a class="btn btn-success text-light" id="btn-add-task">Thêm</a>
                                </div>
                            </div>
                        </div>
                        <ul id="area-add-tasks"class="list-group border rounded">
                            <li class="list-group-item border-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="task_id_1" id="task_id_1" value="1" >
                                    <label class="custom-control-label" for="task_id_1">Check this custom checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item border-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                    <label class="custom-control-label" for="customCheck">Check this custom checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item border-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="task_id_3" name="task_id_3">
                                    <label class="custom-control-label" for="task_id_3">Check this custom checkbox</label>
                                </div>
                            </li>
                        </ul>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>{{-- Modal add task --}}

    <form method="POST" action="{{ route('project.destroy', ['id'=>$projectObj->project_id]) }}" id="fm-deleteProject">
        @csrf
        @method('DELETE')
    </form>    {{-- form delete project --}}

</div>
@endsection
@section('private-js')
    <script>
        $(document).ready(function () {
            window.addChosenClass = (element) => {
               $(element).toggleClass('chosen-user');
            }
            $('#modal-edit-project-detail').on('show.bs.modal', (e) => {;
                $('#inp-project-title').val($('#project-detail-title').text());
                $('#inp-project-desc').val($('#project-intro').text().trim());
                $('#inp-project-detail-start').val("{{$projectObj->project_start_day}}");
                $('#inp-project-detail-end').val("{{$projectObj->project_end_day}}");
            })
            $('#delProjectBtn').click(function (e) {
                e.preventDefault();
                if (confirm('Bạn có chắc muốn xóa Project này?')) {
                    $('#fm-deleteProject').submit();
                }
            });
            let UserSearchData = {
                id:"{{$projectObj->project_id}}"
            }
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
                                    '<a href="javascript:void(0)" onClick="addChosenClass(this)" class="col-12 col-md-4 pl-4 py-2">'
                                       +'<div class="row text-left hover-shadow">'
                                            +'<img height="60px" height="60px" class="col-3 p-1 rounded" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png" alt="">'
                                            +'<div class="col-9">'
                                                +'<h5 class="h5">'+user.user_fullname+'</h5>'
                                                +'<p class="">'+user.user_email+'</p>'
                                            +'</div>'
                                        +'</div>'
                                    +'</a>');
                            }
                        }
                    }
                });
            });
            // $('#form-group-employees').focusout(() => {
            //     $('#available-employees').collapse('hide');
            // })
            $('#available-employees a').each((index,elem) => {
                $(elem).click(function (e) {
                    $('#pxu_id_name').val($(elem).find('span').text());
                    $('#pxu_id').val($(elem).find('input').val());
                    $('#available-employees').collapse('toggle');
                });
            })

            $('#btn-add-task').click(function (e) {
                e.preventDefault();
                $('#area-add-tasks').append('<li class="list-group-item border-0">'
                        +'<div class="custom-control custom-checkbox">'
                            +'<input type="checkbox" class="custom-control-input" name="" id="" value="1" >'
                            +'<label class="custom-control-label" for="task_id_1">'+$('')+'</label>'
                        +'</div>'
                    +'</li>'
                );
            });

            // end
        });
    </script>
@endsection
