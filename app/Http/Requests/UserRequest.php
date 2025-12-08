<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'max:20', Password::min(8)->mixedCase()->numbers()->symbols()],
            'passwordConfirm' => ['required', 'same:password'],
            'date_of_birth' => ['nullable','date'],
            'phone_number' => ['nullable', 'integer'],
            'role' => ['required', 'in:Customer,Seller,Admin']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name field cannot be empty!!',
            'email.required' => 'Email field cannot be empty!!',
            'email.email' => 'Please provide a valid email address!!',
            'email.unique' => 'Email address already in use!!',
            'password.required' => 'Password cannot be empty!!',
            'password.Password' => 'Password must contain one capital letter(A-Z), one small letter(a-z), one number(0-9) and one symbol!!',
            'role' => 'The selected role is invalid'
        ];
    }
}

