<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Đăng Nhập</title>
</head>
<body class="h-100  bg-light">
    @if ($errors->any())
        {{$errors}}
    @endif
    <div id="page-wrapper" class="w-100 h-100 mt-5 my-md-auto d-flex align-items-center justify-content-center">
        <form action="{{ route('auth.login') }}" method="POST" id="fm-login" class="p-3 text-center shadow rounded">
            @csrf
            <h1 class="text-primary my-3">TaskShare</h1>
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Tên đăng nhập">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu">
            </div>
            <div class="d-flex justify-content-around">
                <input name="btn-login" id="btn-login" class="btn btn-outline-success" type="submit" value="Đăng Nhập">
                <a href="#modal-register" name="btn-register" id="btn-register" class="btn btn-outline-primary" data-toggle="modal">Đăng ký</a>
            </div>

        </form>
        <!-- Modal -->
        <div class="modal mx-auto fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">Đăng Ký</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                    <form id="fm-register" action="{{route('auth.register')}}" method="POST"
                    oninput='register_password_confirmation.setCustomValidity(register_password_confirmation.value != register_password.value ? "Mật khẩu nhập lại không đúng." : "")'>
                    @csrf
                        <div class="form-group">
                              <label for="">Tên đăng nhập</label>
                              <input type="text" required
                                class="form-control" name="register_user_name" id="register_user_name" aria-describedby="helpId" placeholder="">
                                <div id="register_user_name_message" class="invalid-feedback"></div>
                                <!-- TODO: This is for server side, there is another version for browser defaults -->
                            </div>
                            <div class="form-group">
                                <label for="">Họ tên</label>
                                <input type="text"
                                  class="form-control" name="register_fullname" id="register_fullname" aria-describedby="helpId" placeholder="">
                                  <div id="register_fullname_message" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Mật khẩu</label>
                                <input type="password" required
                                    class="form-control" name="register_password" id="register_password" aria-describedby="helpId" placeholder="">
                                    <div id="register_password_message" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Nhập lại mật khẩu</label>
                                <input type="password" required
                                    class="form-control" name="register_password_confirmation" id="register_password_confirmation" aria-describedby="helpId" placeholder="">
                                    <div id="register_password_confirmation_message" class="invalid-feedback"></div>

                            </div>


                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" required
                                    class="form-control" name="register_user_email" id="register_user_email" aria-describedby="helpId" placeholder="">
                                <div id="register_user_email_message" class="invalid-feedback"></div>
                            </div>
                            <input disabled="true" type="submit" id="btn-register-submit" class="btn btn-outline-success" value="Đăng Ký"></button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- End Wrapper --}}

</body>
@include('js')

<script>
    $(document).ready(function () {

        function validateInput(inputname, action) {
            $('#register_'+inputname).keyup(function (e) {
                let _url = "{{route('auth.register.validate')}}/"+action;
                let _data = {[inputname]:$('#register_'+inputname).val()};
                let _confirm = '';
                if (inputname === 'password') {
                    _data['password_confirmation'] = $('#register_password_confirmation').val();
                    _confirm = '_confirmation';
                }
                var input = inputname;
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    type: "POST",
                    url: _url,
                    data: _data,
                    dataType: "json",
                    success: function (response) {
                        if (typeof response[[(inputname)]] !== 'undefined') {
                            $('#register_'+inputname).removeClass('is-valid');
                            $('#register_'+inputname).addClass('is-invalid');
                            $('#register_'+inputname+'_message').html(response[[inputname]]);
                        } else {
                            $('#register_'+inputname).removeClass('is-invalid');
                            $('#register_'+inputname).addClass('is-valid');
                        }
                        isValidated();
                    }
                });
            });

        }

        validateInput('user_name','username');
        validateInput('password','password');
        validateInput('user_email','email');

        $('#register_password_confirmation').keyup(function (e) {
            if (($('#register_password_confirmation').val() === $('#register_password').val() && ($('#register_password').val().length >7))) {
                $('#register_password_confirmation').removeClass('is-invalid');
                $('#register_password_confirmation').addClass('is-valid');

                $('#register_password').removeClass('is-invalid');
                $('#register_password').addClass('is-valid');
            } else {
                $('#register_password_confirmation').addClass('is-invalid');
                $('#register_password_confirmation').removeClass('is-valid');

                $('#register_password').addClass('is-invalid');
                $('#register_password').removeClass('is-valid');
            }
        });

        function isValidated() {
            fields = ['register_user_name','register_password','register_password_confirmation','register_user_email'];
            result = true;
            for (const field of fields) {
                if (!$('#'+field).hasClass('is-valid')) {
                    result = false;
                    break;
                }
            }
            if (result == false) {
                $('#btn-register-submit').attr('disabled', true);
            } else {
                $('#btn-register-submit').attr('disabled', false);
            }
        }
        isValidated();

    // End script
    });
    </script>
</html>
