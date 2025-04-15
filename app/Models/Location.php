<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'state',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function skateParks()
    {
        return $this->hasMany(SkatePark::class);
    }
}
