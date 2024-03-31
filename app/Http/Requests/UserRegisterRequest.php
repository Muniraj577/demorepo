<?php

namespace App\Http\Requests;

use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UserRegisterRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email:dns', 'unique:users,email,' . $this->id],
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@&$#%(){}^*+-]).*$/', 'confirmed'],
            'phone' => ['nullable', 'numeric', 'digits_between:10,13'],
            'dob' => ['nullable', 'date', 'date_format:Y-m-d'],
            'gender' => ['nullable', new Enum(GenderEnum::class)],
            'address' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email has already been taken',
            'phone.numeric' => 'Please enter valid phone number',
            'phone.digits_between' => 'Phone must be 10 to 13 digits length',
            'password.required' => 'Password field is required',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be of at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase , lowercase, digit and special character',
            'gender.enum' => 'Gender must be either male, female or others',
        ];
    }
}
