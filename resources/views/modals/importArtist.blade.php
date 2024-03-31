<!-- Modal -->
<div class="modal fade" id="artistImportModal" tabindex="-1" role="dialog" aria-labelledby="artistImportModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="artistImportModalLabel">Import Artist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route("admin.artist.import")}}" id="importArtistForm" enctype="multipart/form-data">
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
                                            <label for="name">Upload CSV &nbsp;<span
                                                        class="req">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" class="form-control" name="file">
                                            <span class="require file text-danger text-left"></span>
                                            @error('file')
                                            <span class="text-danger text-left">{{ $message }}</span>
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
                <button type="button" class="btn btn-primary" onclick="importArtist(event);" id="importArtist">Save changes</button>
            </div>
        </div>
    </div>
</div>