<?php

namespace App\Imports;

use App\Enum\GenderEnum;
use App\Models\Artist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ArtistsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue, WithEvents, WithValidation, SkipsOnFailure, SkipsEmptyRows, SkipsOnError
{
    use Importable, SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Artist([
            'name' => $row['name'],
            'dob' => $row['dob'],
            'gender' => $row['gender'],
            'address' => $row['address'],
            'first_release_year' => $row['first_release_year'],
            'no_of_albums_released' => $row['no_of_albums_released']
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'name' => ["required", "string"],
            "dob" => ["required", "date", "date_format:Y-m-d"],
            "gender" => ["required", new Enum(GenderEnum::class)],
            "address" => ["required", "string"],
            "first_release_year" => ["required", "date_format:Y"],
            "no_of_albums_released" => ["required", "integer"],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            "name.required" => "Name is required",
            "name.string" => "Name must be a string",
            "dob.required" => "Dob is required",
            "dob.date" => "Dob must be a valid date",
            "dob.date_format" => "Dob must be in format Y-m-d",
            "address.required" => "Address is required",
            "address.string" => "Address must be string",
            "first_release_year.required" => "First release year is required",
            "first_release_year.date_format" => "First release year format should be Y(eg:1996)",
            "no_of_albums_released.required" => "This field is required",
            "no_of_albums_released.integer" => "This field must be an integer",
        ];
    }

    public function registerEvents(): array
    {
        return [
          ImportFailed::class => function(ImportFailed $event){
            Log::error('Import Error - '.json_encode($event));
          }
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::channel('job_failure')->error($failure->row());
            Log::channel('job_failure')->error($failure->attribute());
            Log::channel('job_failure')->error($failure->errors());
            Log::channel('job_failure')->error($failure->values());
        }
        Log::channel('job_failure')->error('queue failed error');
    }

    public function onError(Throwable $e)
    {
        Log::channel('job_failure')->error('Import error -'. $e);
    }
}
