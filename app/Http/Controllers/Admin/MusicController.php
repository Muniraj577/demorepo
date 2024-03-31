<?php

namespace App\Http\Controllers\Admin;

use App\Enum\GenreEnum;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Music;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class MusicController extends Controller
{
    use AdminMethods;

    private $page = "music.";

    public function index($artist_id)
    {
        $musics = Music::where('artist_id', $artist_id)
            ->with('artist:id,name,gender')
            ->paginate(5);
        $artist = Artist::whereId($artist_id)->first();
        return $this->view($this->page . 'index', [
           'musics' => $musics,
           'artist' => $artist
        ])->with('id');
    }

    public function store(Request $request)
    {
        $validator = $this->__validation($request);
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $input = $request->except("_token");
                $music = Music::create($input);
                DB::commit();
                return response()->json([
                    "msg" => "Music created successfully",
                    "redirectRoute" => route("admin.artist.musics", $request->artist_id),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError($e->getMessage());
            }
        }
    }

    public function edit($id)
    {
        $music = Music::whereId($id)->with("artist:id,name")->first();
        return response()->json([
            "music" => $music,
            "msg" => "Music retrieved successfully"
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->__validation($request);
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $music = Music::find($id);
                if ($music) {
                    $msg = "Music updated successfully";
                    $input = $request->except("_token");
                    $music->update($input);
                    DB::commit();
                } else {
                    $msg = "No music found";
                }
                return response()->json([
                    "msg" => $msg,
                    "redirectRoute" => route("admin.artist.musics", $request->artist_id),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError($e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $music = Music::find($id);
            $artistId = $music->artist_id;
            $music->delete();
            DB::commit();
            return response()->json([
                "msg" => "Music deleted successfully",
                "redirectRoute" => route("admin.artist.musics", $artistId),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    private function __validation($data)
    {
        return Validator::make($data->all(), [
           'artist_id' => ['required', 'integer'],
           'title' => ['required', 'string'],
           'album_name' => ['required', 'string'],
           'genre' => ['required', new Enum(GenreEnum::class)],
        ]);
    }
}
