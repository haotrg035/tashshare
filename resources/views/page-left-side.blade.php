<div id="page-left-side" class="col-lg-2 text-dark h-100 p-0">
    <h3 class="font-weight-bold text-center p-2 d-none d-md-block">TaskShare</h3>
    <nav class="navbar navbar-expand-lg navbar-light d-md-flex flex-md-column">
        <a class="navbar-brand border-bottom d-block d-md-none" href="#">TaskShare</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 d-flex flex-column w-100">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard')}}"><h3 class="h3 font-weight-bold text-dark"><i class="fa fa-home mr-1" aria-hidden="true"></i> Dashboard</h3></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><h3 class="h3 font-weight-bold text-dark"><i class="fa fa-book mr-1 " aria-hidden="true"></i> Dự án của tôi</h3></a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#"><h3 class="h3 font-weight-bold"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</h3></a>
                </li> --}}
            </ul>
        </div>
    </nav>
</div>
