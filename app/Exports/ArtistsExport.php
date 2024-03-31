<?php

namespace App\Exports;

use App\Http\Resources\ArtistListResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArtistsExport implements FromCollection, ShouldQueue, WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $artists;

    public function __construct($artists)
    {
        $this->artists = $artists;
    }

    public function headings(): array
    {
        return [
          'S.N',
          'Name',
          'Gender',
          'Dob',
          'Address',
          'First Release Year',
          'No. of Albums Released'
        ];
    }

    public function collection()
    {
        return ArtistListResource::collection($this->artists);
    }


}
