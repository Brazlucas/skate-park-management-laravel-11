<?php

namespace App\Http\Requests\SkatePark;

use Illuminate\Http\Request;

class StoreSkateParkRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ];
    }
}