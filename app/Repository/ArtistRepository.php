<?php

namespace App\Repository;

use App\Contracts\ArtistInterface;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class ArtistRepository implements ArtistInterface
{
    public function getAll($relations=[])
    {
        return Artist::with($relations)->withCount($relations)->get();
    }

    public function save($data)
    {
        $input = $data->except("_token");
        $input['created_at'] = now();
        $input['updated_at'] = date('Y-m-d H:i:s');
        $columns = implode(', ', array_keys($input));
        $values = implode(', ', array_fill(0, count($input), '?'));
        DB::statement("INSERT INTO artists ($columns) VALUES ($values)", array_values($input));
//        Artist::create($input);
    }

    public function getById($id)
    {
        return Artist::find($id);
    }

    public function findOrFail($id)
    {
        return Artist::findOrFail($id);
    }

    public function update($data, $id)
    {
//        $artist = $this->findOrFail($id);
        $input = $data->except(["_token", "_method"]);
        $input['updated_at'] = now();
        $updatedValues = [];
        foreach ($input as $column => $value) {
            $updatedValues[] = "$column = ?";
        }
        $updateString = implode(', ', $updatedValues);
        $condition = 'id = ?';
        $query = "UPDATE artists SET $updateString WHERE $condition";
        $values = array_merge(array_values($input), [$id]);
        DB::statement($query, $values);
//        $artist->update($input);
    }

    public function delete($id)
    {
        DB::statement('DELETE FROM artists WHERE id=?', [$id]);
//        return Artist::destroy($id);
    }

}