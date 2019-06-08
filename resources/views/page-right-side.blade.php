<div id="page-right-side" class="col-lg-10 ">
    <div class="container bg-white border-bottom text-dark shadow-sm">
        <nav class="nav justify-content-end">
            <div class="dropdown">
                    <a class="nav-link dropdown-toggle" id="noti-menu" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="fa fa-bell-o font-weight-bold" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu mr-3 dropdown-menu-right" style="min-width:19.5rem;" aria-labelledby="noti-menu">
                        <a class="dropdown-item" href="#" style="word-wrap: break-word; white-space: pre-line">Bạn có lời mời tham gia dự án <strong>Đồ án 2</strong> bởi <strong>Trương Nhựt Hào</strong></a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" style="word-wrap: break-word; white-space: pre-line">Còn <strong>3 ngày</strong> nữa công việc của bạn trong dự án <strong>Đồ án 2</strong> sẽ đến thời hạn</a>
                    </div>
                </div>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" id="username-menu" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    {{$currUser->user_fullname}}
                </a>
                <div class="dropdown-menu dropdown-menu-right mr-3" aria-labelledby="username-menu">
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i> Hồ sơ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- end topbar menu -->
    @yield('ContentArea')
</div><!-- Page Right side -->
