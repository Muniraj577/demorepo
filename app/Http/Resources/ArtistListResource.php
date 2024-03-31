<?php

namespace App\Http\Resources;

use App\Enum\GenderEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->sequence_number,
          'name' => $this->name,
          'gender' => GenderEnum::getLabel($this->gender),
          'dob' => getFormattedDate('Y-m-d', $this->dob),
          'address' => $this->address,
          'first_release_year' => $this->first_release_year,
          'no_of_albums_released' => $this->no_of_albums_released,
        ];
    }
}
