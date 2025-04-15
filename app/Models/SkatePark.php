<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkatePark extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'name',
        'description',
        'image',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
