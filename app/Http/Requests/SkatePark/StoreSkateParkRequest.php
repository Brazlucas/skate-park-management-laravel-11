<?php

namespace App\Http\Requests\SkatePark;


use Illuminate\Foundation\Http\FormRequest;

class StoreSkateParkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'image' => 'required|string'
        ];
    }
}