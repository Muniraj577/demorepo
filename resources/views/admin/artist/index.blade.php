@extends('layouts.admin.app')
@section('title', 'Artist')
@section('artist', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row col-12 mb-2">
                <div class="col-sm-6">
                    <h1>All Artists</h1>
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
                                @hasRole('artist_manager')
                                <a href="{{route("admin.artist.export")}}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Export Artists
                                </a>
                                <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal"
                                   data-target="#artistImportModal">
                                    <i class="fas fa-upload"></i> Import Artists
                                </a>
                                <a href="{{route('admin.artist.create')}}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Artist
                                </a>
                                @endhasRole
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="Artist" class="table table-responsive-xl">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>First Release Year</th>
                                    <th>No. of Albums Released</th>
                                    <th>Total Songs</th>
                                    <th class="hidden">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($artists as $key => $artist)
                                    <tr>
                                        <td>{{++$id}}</td>
                                        <td>{{$artist->name}}</td>
                                        <td>{{getFormattedDate('Y-m-d',$artist->dob)}}</td>
                                        <td>{{App\Enum\GenderEnum::getLabel($artist->gender)}}</td>
                                        <td>{{$artist->address}}</td>
                                        <td>{{$artist->first_release_year}}</td>
                                        <td>{{$artist->no_of_albums_released}}</td>
                                        <td>{{$artist->musics_count}}</td>
                                        <td>
                                            <div class="d-inline-flex">
                                                @hasRole('artist_manager')
                                                <a href="{{ route('admin.artist.edit', $artist->id) }}"
                                                   class="edit btn btn-sm" title="Edit Artist">
                                                    <i class='fas fa-edit' style='color: blue;'></i>
                                                </a>
                                                @endhasRole
                                                <a href="{{ route('admin.artist.musics', $artist->id) }}"
                                                   class="edit btn btn-sm" title="View Artist Songs">
                                                    <i class='fas fa-eye' style='color: blue;'></i>
                                                </a>
                                                @hasRole('artist_manager')
                                                <a href="javascript:void(0);"
                                                   onclick="deleteData('{{$artist->id}}', '{{ route('admin.artist.delete', $artist->id) }}', ['artist_manager'])"
                                                   class="edit btn btn-sm" title="Delete Artist">
                                                    <i class='fas fa-trash' style='color: red;'></i>
                                                </a>
                                                @endhasRole
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("modals.importArtist")
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#Artist").DataTable({
                "responsive": false,
                "autoWidth": false,
                "dom": 'lBfrtip',
                "buttons": [{
                    extend: 'collection',
                    text: "<i class='fa fa-ellipsis-v'></i>",
                    buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                        {
                            extend: 'csv',

                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'excel',

                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'pdf',

                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'print',

                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            },

                        },
                    ],

                },
                    {
                        extend: 'colvis',
                        columns: ':not(.hidden)'
                    }
                ],

                "language": {
                    "infoEmpty": "No entries to show",
                    "emptyTable": "No data available",
                    "zeroRecords": "No records to display",
                }
            });
            dataTablePosition();


            $("#artistImportModal").on("hidden.bs.modal", function (e) {
                e.preventDefault();
                $('.require').css('display', 'none');
                $("#importArtistForm")[0].reset();
            });
        });


        function importArtist(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#importArtistForm").attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData($("#importArtistForm")[0]),
                processData: false,
                contentType: false,

                beforeSend: function () {
                    setSubmittingAnimation('importArtist');
                },
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
                        $("#importArtistForm")[0].reset();
                        $("#artistImportModal").modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }

                },
                complete: function () {
                    clearAnimatedInterval('importArtist', 'Save Changes');
                },
            })
        }


    </script>
@endsection
