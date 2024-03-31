@extends('layouts.admin.app')
@section('title', 'Artist')
@section('artist', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row col-12 mb-2">
                <div class="col-sm-6">
                    <h1>Create Artist</h1>
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
                                <a href="{{ route('admin.artist.index') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.artist.store') }}" method="POST"
                                  id="form">
                                @csrf
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
                                                        <label for="name">Name &nbsp;<span
                                                                    class="req">*</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="name"
                                                               class="form-control @error('name') is-invalid @enderror"
                                                               placeholder="Enter name"
                                                               value="{{ old('name') }}">
                                                        <span class="require name text-danger"></span>
                                                        @error('name')
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
                                                               value="{{old('dob')}}" id="dob" readonly>
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
                                                        <label for="gender">Gender</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="gender" class="form-control">
                                                            <option value="">Select Gender</option>
                                                            @foreach(getConstants(\App\Enum\GenderEnum::class) as $gender)
                                                                <option value="{{$gender->value}}">{{ucfirst(strtolower($gender->name))}}</option>
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
                                                        <input type="text" name="address" value="{{ old('address') }}"
                                                               class="form-control @error('address') is-invalid @enderror">
                                                        <span class="require address text-danger"></span>
                                                        @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
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
                                                        <label for="first_release_year">First Release Year</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="first_release_year" id="fry"
                                                               value="{{ old('first_release_year') }}"
                                                               class="form-control @error('first_release_year') is-invalid @enderror"
                                                               readonly>
                                                        <span class="require first_release_year text-danger"></span>
                                                        @error('first_release_year')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="no_of_albums_released">No of albums released</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="no_of_albums_released"
                                                               onkeyup="return onlynumbers(event);"
                                                               onkeypress="return onlynumbers(event);"
                                                               onpaste="onpasteString(event);"
                                                               value="{{ old('no_of_albums_released') }}"
                                                               class="form-control @error('no_of_albums_released') is-invalid @enderror">
                                                        <span class="require no_of_albums_released text-danger"></span>
                                                        @error('no_of_albums_released')
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
                                            class="btn btn-primary" id="submitArtist">Submit
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

            $("#fry").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true,
                clearBtn: true,
            })
        });

        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#form").attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData(this.form),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function(){
                    setSubmittingAnimation('submitArtist');
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
                    clearAnimatedInterval('submitArtist', 'Submit')
                }
            });
        }
    </script>
@endsection
