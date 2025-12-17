<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            "name" => ['required', 'string', 'min:3', 'max:255'],
            "description" => ['required', 'string'],
            "original_price" => ['required', 'decimal:2'],
            "current_price" => ['required', 'decimal:2'],
            "quantity" => ['required', 'integer'],
            "user_id" => ['required', 'exists:users,id'],
            "category_id" => ['required', 'exists:categories,id'],
            "images" => ['required', 'array', 'min:1', 'max:5']
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['images'] = ['nullable', 'array', 'max:5'];
            $rules['deleted_images'] = ['nullable', 'array'];
            $rules['deleted_images.*'] = ['integer', 'exists:images,id'];
        }

        return $rules;
    }
}
