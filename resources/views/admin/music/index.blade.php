@extends('layouts.admin.app')
@section('title', 'Artist')
@section('artist', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row col-12 mb-2">
                <div class="col-sm-6">
                    <h1>All Music of {{$artist->name}}</h1>
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
                                @hasRole('artist')
                                <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal"
                                   data-target="#musicModal">
                                    <i class="fas fa-plus"></i> Add Music
                                </a>
                                @endhasRole
                                <a href="{{route('admin.artist.index')}}" class="btn btn-primary ml-2">
                                    <i class="fas fa-arrow-left"></i> Go back to Artist Page
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <table id="Music" class="table table-responsive-xl">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Artist Name</th>
                                    <th>Title</th>
                                    <th>Album Name</th>
                                    <th>Genre</th>
                                    @hasRole('artist')
                                    <th class="hidden">Action</th>
                                    @endhasRole
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($musics as $key => $music)
                                    <tr>
                                        <td>{{++$id}}</td>
                                        <td>{{$artist->name}}</td>
                                        <td>{{$music->title}}</td>
                                        <td>{{$music->album_name}}</td>
                                        <td>{{\App\Enum\GenreEnum::getLabel($music->genre)}}</td>
                                        @hasRole('artists')
                                        <td>
                                            <div class="d-inline-flex">
                                                <a href="javascript:void(0)" data-target-id="{{$music->id}}"
                                                   data-toggle="modal" data-target="#musicModal"
                                                   class="edit btn btn-sm editMusic" title="Edit Music">
                                                    <i class='fas fa-edit' style='color: blue;'></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                   onclick="deleteData('{{$music->id}}', '{{ route('admin.music.delete', $music->id) }}', ['artist'])"
                                                   class="edit btn btn-sm" title="Delete Music">
                                                    <i class='fas fa-trash' style='color: red;'></i>
                                                </a>

                                            </div>
                                        </td>
                                        @endhasRole
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $musics->links() !!}
                    </div>
                </div>
            </div>

            <div class="row">
                @include("modals.addMusic")
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function () {
            $(".editMusic").on('click', function () {
                @if(getUser()->role != 'artist')
                alert('Unauthorized');
                @else
                $("#musicModal").modal('show');
                @endif
            });
            $("#musicModal").on("show.bs.modal", function (e) {
                let id = $(e.relatedTarget).data('target-id');
                if (id === undefined) {
                    let actionUrl = "{{route('admin.music.store')}}";
                    $("#musicForm").attr("action", actionUrl);
                    $("#artistId").val(`{{$artist->id}}`);
                    $("#artistName").val(`{{$artist->name}}`);
                } else {
                    let url = "{{route('admin.music.edit', ':id')}}";
                    url = url.replace(":id", id);
                    $.ajax({
                        url: url,
                        type: "get",
                        success: function (response) {
                            let music = response.music;
                            $("#title").val(music.title);
                            $("#album_name").val(music.album_name);
                            $("#artistId").val(music.artist.id);
                            $("#artistName").val(music.artist.name);
                            $("#genre").val(music.genre);
                            let updateUrl = "{{route('admin.music.update', ':id')}}";
                            updateUrl = updateUrl.replace(":id", id);
                            var input = $("<input>")
                                .attr("type", "hidden")
                                .attr("name", "_method")
                                .val('put');
                            $("#musicForm").attr("action", updateUrl);
                            $("#musicForm").append(input);
                        }
                    })
                }
            });

            $("#musicModal").on("hidden.bs.modal", function (e) {
                $(".require").css("display", "none");
                $("#musicForm").attr("action", "");
                $("#musicForm input[name='_method']").remove();
                $(this).find('form')[0].reset();
            });
        });

        function saveMusic(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#musicForm").attr("action");
            var data = $("#musicForm").serialize();
            $.ajax({
                url: url,
                type: 'post',
                data: data,
                success: function (data) {
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function (key, value) {
                            $('.' + key).css('display', 'block').html(value);
                        });
                    } else if (!data.errors && !data.db_error) {
                        toastr.success(data.msg);
                        setTimeout(function () {
                            location.href = data.redirectRoute;
                        }, 1000);
                    }

                }
            })
        }
    </script>
@endsection
