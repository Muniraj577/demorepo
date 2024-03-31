<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ArtistInterface;
use App\Exports\ArtistsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistRequest;
use App\Jobs\ImportArtist;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ArtistController extends Controller
{
    use AdminMethods;

    private $page = "artist.";
    private $redirectTo = "admin.artist.index";

    protected $artistRepository;

    public function __construct(ArtistInterface $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function index()
    {
        $artists = $this->artistRepository->getAll(['musics']);
        return $this->view($this->page . "index", [
            "artists" => $artists
        ])->with("id");
    }

    public function create()
    {
        return $this->view($this->page . "create");
    }

    public function store(ArtistRequest $request)
    {
        try {
            DB::beginTransaction();
            $artist = $this->artistRepository->save($request);
            DB::commit();
            return $this->successMsgAndRedirect("Artist created successfully", $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $artist = $this->artistRepository->findOrFail($id);
        return $this->view($this->page . "edit", [
            "artist" => $artist
        ]);
    }

    public function update(ArtistRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $artist = $this->artistRepository->update($request, $id);
            DB::commit();
            return $this->successMsgAndRedirect('Artist updated successfully', $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $artist = $this->artistRepository->delete($id);
            DB::commit();
            return $this->successMsgAndRedirect('Artist deleted', $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function export()
    {
        $artists = DB::select('SELECT * FROM artists');
        foreach ($artists as $index => $artist){
            $artist->sequence_number = $index + 1;
        }
        return Excel::download((new ArtistsExport($artists)), 'artists.csv');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'file' => ['required', 'file', 'mimes:csv'],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()]);
        }
        if($validator->passes()){
            try {
                /**
                 * To import using job we must store the file in temp path and then access that file in our job to import the data
                 * from file
                */
                $tempFilePath = $request->file('file')->storeAs('temporary', 'artist.csv');
                dispatch(new ImportArtist($tempFilePath))->delay(30);
                return response()->json([
                   'msg' => 'Artist imported successfully',
                ]);
            } catch (\Exception $e){
                return $this->sendError($e->getMessage());
            }
        }
    }
}
