<?php

namespace App\Http\Requests\Rental;

use Illuminate\Http\Request;

class StoreRentalRequest extends Request
{
    public function rules(): array
    {
        return [
            'skate_park_id' => 'required|exists:skate_parks,id',
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ];
    }
}