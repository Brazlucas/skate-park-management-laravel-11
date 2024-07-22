<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'skate_park_id',
        'renter_name',
        'start_time',
        'end_time',
    ];

    public function skatePark()
    {
        return $this->belongsTo(SkatePark::class);
    }
}
