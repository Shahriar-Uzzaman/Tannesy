<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            "name" => ['nullable', 'string', 'min:3', 'max:255'],
            "description" => ['nullable', 'string'],
            "original_price" => ['nullable', 'decimal:2'],
            "current_price" => ['nullable', 'decimal:2'],
            "quantity" => ['nullable', 'integer'],
            "user_id" => ['nullable', 'exists:users,id'],
            "category_id" => ['nullable', 'exists:categories,id'],
        ];
    }
}
