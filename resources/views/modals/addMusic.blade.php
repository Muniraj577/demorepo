<!-- Modal -->
<div class="modal fade" id="musicModal" tabindex="-1" role="dialog" aria-labelledby="musicModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="musicModalLabel">Add Music</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="musicForm">
                    @csrf
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p class="db_error"></p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Artist Name &nbsp;<span
                                                        class="req">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Artist Name"
                                                   id="artistName" readonly>
                                            <input type="hidden" name="artist_id" id="artistId"
                                                   class="form-control @error('artist_id') is-invalid @enderror"
                                                   placeholder="Enter name"
                                                   value="{{ old('artist_id') }}">
                                            <span class="require artist_id text-danger text-left"></span>
                                            @error('artist_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="dob">Title <span class="req">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="title" class="form-control"
                                                   value="{{old('title')}}" id="title">
                                            <span class="require title text-danger text-left"></span>
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="dob">Album Name <span class="req">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="album_name" class="form-control"
                                                   value="{{old('album_name')}}" id="album_name">
                                            <span class="require album_name text-danger text-left"></span>
                                            @error('album_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="gender">Genre</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="genre" class="form-control" id="genre">
                                                <option value="">Select Genre</option>
                                                @foreach(getConstants(\App\Enum\GenreEnum::class) as $genre)
                                                    <option value="{{$genre->value}}">{{ucfirst(strtolower($genre->name))}}</option>
                                                @endforeach
                                            </select>
                                            <span class="require genre text-danger text-left"></span>
                                            @error('genre')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveMusic" onclick="saveMusic(event);">Save changes</button>
            </div>
        </div>
    </div>
</div>