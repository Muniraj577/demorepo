<?php

namespace App\Http\Requests;

use App\Enum\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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

    public function messages()
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
}
