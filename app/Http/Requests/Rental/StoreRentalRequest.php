<?php

namespace App\Http\Requests\Rental;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'skate_park_id' => 'required|exists:skate_parks,id',
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'renter_id' => 'required|exists:users,id',
            'rent_value' => 'required|numeric',
        ];
    }
}