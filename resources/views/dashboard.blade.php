@extends('master')
@section('ContentArea')
{{-- {{dd($joinedProjects)}} --}}
<div id="page-content-area" class="h-100 container p-0">
        <div class="bg-white border mt-2 shadow-sm">
            <header class=" p-2 d-flex align-items-center justify-content-between border-bottom">
            <form action="{{ route('dashboard.search')}}" method="get" class="mr-2" style="max-width:30rem">
                    @csrf
                    <div class="input-group">

                        <input type="text" name="inp-project-search" id="inp-project-search" placeholder="Tìm dự án..." class="form-control border-right-0" aria-describedby="prefixId" autocomplete="off">
                        <div class="input-group-append">
                            <button class="input-group-text bg-white border-left-0">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <a id="btn-add-project" class="btn border hover-gray"  href="#modal-add-project" data-toggle="modal" role="button"><i class="fa fa-plus" aria-hidden="true"></i><span class="d-none d-md-inline"> Thêm Dự Án</span></a>
            </header>

            <div id="project-area" class="row pt-3 pb-2 pr-3 pl-3">
                @if (count($joinedProjects)>0)
                    @foreach ($joinedProjects as $project)
                    <div class="col-md-4">
                        <a href="{{route('project.show',$project->project_id)}}" class=" card mb-3 card-ongoing text-dark rounded-0 border" >
                            <div class="card-body p-1 p-md-3">
                                <h5 class="card-title text-truncate mb-0 mb-md-2 fw-600">{{$project->project_name}}</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item pt-1 pb-1 text-muted">
                                        <i class="fa fa-user-circle-o" aria-hidden="true"> </i><strong class="d-none d-md-inline"> Quản lý:</strong> {{$managers->find($project->project_manager_id)->user_fullname}}
                                    </li>
                                    <li class="list-group-item pt-1 pb-1 text-muted">
                                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i></i><strong class="d-none d-md-inline"> Ngày tạo:</strong> {{converDate($project->project_start_day)}}
                                    </li>
                                    <li class="list-group-item pt-1 pb-1 text-muted">
                                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i></i><strong class="d-none d-md-inline"> Hạn nộp:</strong> {{converDate($project->project_end_day)}}
                                    </li>
                                    <li class="list-group-item pt-1 pb-1 text-muted">
                                            <i class="fa fa-user-circle" aria-hidden="true"></i></i><strong class="d-none d-md-inline"> Nhân lực:</strong> {{$employeeNums[$project->project_id]}}
                                    </li>
                                    <li class="list-group-item pt-3 pb-0">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary font-weight-bold" role="progressbar" style="width: {{$project->process}}%;"
                                                aria-valuenow="{{$project->process}}" aria-valuemin="0" aria-valuemax="100">{{$project->process}}%</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="text-muted text-center w-100"><i>Không tìm thấy dự án nào</i></div>
                @endif
                <!-- !End single project -->

            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-project" tabindex="-1" role="dialog" aria-labelledby="Thêm Project" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><b>Tạo Dự Án Mới</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('project.store')}}" method="POST" id="fm-add-project">
                        @csrf
                        <div class="form-group">
                          <label for="inp-project-title">Tên Dự Án</label>
                          <input type="text" name="inp-project-title" id="inp-project-title" class="form-control" placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                          <label for="inp-project-desc">Mô tả</label>
                          <textarea class="form-control" name="inp-project-desc" id="inp-project-desc" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inp-project-detail-start">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control" readonly name="inp-project-start" id="inp-project-start" aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Mặc định là ngày khởi tạo dự án</small>
                                  </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inp-project-detail-end">Hạn Hoàn Thành</label>
                                    <input type="date" class="form-control" name="inp-project-end" id="inp-project-end" aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Vui lòng chọn thời hạn cho dự án</small>
                                  </div>
                            </div>
                        </div>
                        <div class="form-group d-none" >
                                <label for="inp-project-detail-end">Ngân sách</label>
                                <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">VNĐ</span>
                                        </div>
                                    <input type="number" step="1000" spellcheck="true" class="form-control" id="inp-project-budget" name="inp-project-budget" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input id="btn-add-project-submit" class="btn btn-success" type="submit" value="Tạo">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Edit Modal -->
@endsection

@section('private-js')
    <script>

        $(document).ready(function () {
            d = getISODATE();
            $('#modal-add-project').on('show.bs.modal', (e) => {
                $('#inp-project-title').val();
                $('#inp-project-desc').val();
                $('#inp-project-start').val(d);
                $('#inp-project-end').val();
                $('#inp-project-budget').val(0);
            })
        });
    </script>
@endsection
