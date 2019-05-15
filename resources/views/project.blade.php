@extends('master')
@section('ContentArea')

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
            <!-- project info left col -->
            <div class="col-md-4 px-0 px-md-2" >
                <div class="mt-2 bg-white shadow-sm border " ">
                    <h3 class="border-bottom p-2 d-flex justify-content-between">
                        <span>Nhân sự</span>
                        <a href="#modal-add-task" data-toggle="modal">
                            <i class="fa fa-plus text-success"  aria-hidden="true"></i>
                        </a>
                    </h3>
                    <!-- Title -->
                    <div style="min-height:190px; max-height:190px; overflow: auto;">
                        @for ($i = 0; $i < count($users); $i++)
                        @php
                            $raw_task = $tasks->where('user_id',$users[$i]->user_id)->toArray();
                            $task = [];
                            foreach ($raw_task as $item) {
                                $task = $item;
                                break;
                            }
                        @endphp
                        <div class="my-1 border-bottom px-2">
                            <a href="https://www.google.com">
                                <div class="media hover-shadow">
                                    <a class="d-flex " href="#">
                                        <img width="25" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-512.png" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h5>{{$users[$i]->user_fullname}}</h5>
                                        {{ $task['task_pos']}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- !End Employee -->
                        @endfor

                    </div>

                </div>
            </div>
            <!-- project info right col -->
        </div>

    </div>

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
    </div> <!-- Edit Modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal-add-task" tabindex="-1" role="dialog" aria-labelledby="Thêm nhân sự" aria-hidden="true">
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
    </div>
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
                            console.log(response)
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
        });
    </script>
@endsection
