<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'skate_park_id',
        'skate_park_name',
        'renter_name',
        'renter_id',
        'start_time',
        'end_time',
        'rent_value',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function skatePark()
    {
        return $this->belongsTo(SkatePark::class);
    }

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}