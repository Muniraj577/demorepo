@extends('layouts.admin.app')
@section('title', 'User')
@section('user', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row col-12 mb-2">
                <div class="col-sm-6">
                    <h1>Edit User</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title float-right">
                                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                                  enctype="multipart/form-data" id="form">
                                @csrf
                                @method('put')
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <p class="db_error"></p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="name">First Name &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="first_name"
                                                               class="form-control @error('first_name') is-invalid @enderror"
                                                               placeholder="Enter first name"
                                                               value="{{ $user->first_name }}">
                                                        <span class="require first_name text-danger"></span>
                                                        @error('first_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="name">Last Name &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="last_name"
                                                               class="form-control @error('last_name') is-invalid @enderror"
                                                               placeholder="Enter last name"
                                                               value="{{ $user->last_name }}">
                                                        <span class="require last_name text-danger"></span>
                                                        @error('last_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="email">Email Address &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="email" name="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               value="{{ $user->email }}">
                                                        <span class="require email text-danger"></span>
                                                        @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="password">Password &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="password" name="password" id="password" value=""
                                                               class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                                                        <span class="require password text-danger"></span>
                                                        @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="password_confirmation">Confirm Password &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="password" name="password_confirmation"
                                                               class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="off">
                                                        @error('password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">Note</div>
                                                    <div class="col-md-10">
                                                        <p>Password must contain at least uppercase, lowercase, numeric
                                                            and
                                                            special characters(!@&$#%(){}^*+-)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="gender">Gender</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="gender" class="form-control">
                                                            <option value="">Select Gender</option>
                                                            @foreach(getConstants(\App\Enum\GenderEnum::class) as $gender)
                                                                <option value="{{$gender->value}}" @selected($user->gender == $gender->value)>{{ucfirst(strtolower($gender->name))}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="require gender text-danger"></span>
                                                        @error('gender')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="address">Address</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="address" value="{{ $user->address }}"
                                                               class="form-control @error('address') is-invalid @enderror">
                                                        <span class="require address text-danger"></span>
                                                        @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="dob">DOB <span class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="dob" class="form-control"
                                                               value="{{getFormattedDate('Y-m-d',$user->dob)}}" id="dob"
                                                               readonly>
                                                        <span class="require dob text-danger"></span>
                                                        @error('dob')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="phone">Phone</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="phone" value="{{ $user->phone }}"
                                                               class="form-control @error('phone') is-invalid @enderror">
                                                        <span class="require phone text-danger"></span>
                                                        @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="gender">Role</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="role" class="form-control">
                                                            <option value="">Select Role</option>
                                                            @foreach(getConstants(\App\Enum\RoleEnum::class) as $role)
                                                                <option value="{{$role->value}}" @selected($user->role == $role->value)>{{\App\Enum\RoleEnum::getLabel($role->value)}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="require role text-danger"></span>
                                                        @error('role')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" onclick="submitForm(event);"
                                            class="btn btn-primary" id="submitUser">Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#dob").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            })
        });

        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#form").attr("action");
            $.ajax({
                url: url,
                type: 'post',
                _method: "put",
                data: new FormData(this.form),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function(){
                    setSubmittingAnimation('submitUser');
                },
                success: function (data) {
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function (key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        toastr.success(data.msg);
                        setTimeout(function () {
                            location.href = data.redirectRoute;
                        }, 1000);
                    }
                },
                error: function (xhr) {
                    var response = xhr.responseJSON;
                    if ($.isEmptyObject(response.errors) == false) {
                        var error_html = "";
                        $.each(response.errors, function (key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    }
                },
                complete: function (){
                    clearAnimatedInterval('submitUser', 'Submit')
                }
            });
        }
    </script>
@endsection
