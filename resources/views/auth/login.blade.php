<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <style>
        .toast-top-container {
            position: absolute;
            top: 65px;
            width: 280px;
            right: 40px;
            height: auto;
        }
    </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/">{{ env('APP_NAME') }}</a>
    </div>
    <div class="card" id="loginCard">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password" required
                           autocomplete="current-password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block float-right">Sign In</button>
                    </div>
                    <div class="col-7">
                        <button type="button" class="btn btn-info btn-block float-right" id="showRegisterForm">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card d-none" id="registerCard">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register as a new user</p>
            <form action="{{route("register")}}" method="post" id="registerForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="first_name" placeholder="First name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <span class="require first_name text-danger"></span>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="last_name" placeholder="Last name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <span class="require last_name text-danger"></span>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <span class="require email text-danger"></span>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <span class="require password text-danger"></span>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Confirm password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <span class="require password_confirmation text-danger"></span>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" onclick="registerUser();">
                            Register
                        </button>
                    </div>

                </div>
            </form>
            <a href="javascript:void(0);" class="text-center" id="showLoginForm">I already have an account</a>
        </div>
    </div>
</div>
<script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>

<script>
    $(function () {
        $("#showLoginForm").on("click", () => {
            resetForm();
            $("#registerCard").addClass('d-none');
            $("#loginCard").removeClass('d-none');
        });

        $("#showRegisterForm").on("click", () => {
            resetForm();
            $("#registerCard").removeClass('d-none');
            $("#loginCard").addClass('d-none');
        });
    });

    function registerUser() {
        event.preventDefault();
        $('.require').css('display', 'none');
        let url = $("#registerForm").attr("action");
        $.ajax({
            url: url,
            type: 'post',
            data: $("#registerForm").serialize(),
            success: function (data) {
                if (data.db_error) {
                    $(".alert-warning").css('display', 'block');
                    $(".db_error").html(data.db_error);
                } else if (data.errors) {
                    $.each(data.errors, function (key, value) {
                        $('.' + key).css('display', 'block').html(value);
                    });
                } else if (!data.errors && !data.db_error) {
                    toastr.success(data.msg);
                    resetForm();
                    setTimeout(function () {
                        $("#registerCard").addClass('d-none');
                        $("#loginCard").removeClass('d-none');
                    }, 500);
                }

            },
            error: function (xhr) {
                var response = xhr.responseJSON;
                if ($.isEmptyObject(response.errors) == false) {
                    $.each(response.errors, function (key, value) {
                        $('.' + key).css('display', 'block').html(value);
                    });
                }
            }
        });
    }

    function resetForm() {
        $("#registerForm")[0].reset();
        $('.require').css('display', 'none');
    }


    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-container",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>


</body>

</html>


