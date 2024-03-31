<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'dob', 'gender', 'address', 'first_release_year', 'no_of_albums_released'
    ];

    public function musics(): HasMany
    {
        return $this->hasMany(Music::class, 'artist_id', 'id');
    }
}
