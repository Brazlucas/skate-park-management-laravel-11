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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($rental) {
            $conflict = Rental::where('skate_park_id', $rental->skate_park_id)
                ->where(function ($query) use ($rental) {
                    $query->whereBetween('start_time', [$rental->start_time, $rental->end_time])
                          ->orWhereBetween('end_time', [$rental->start_time, $rental->end_time])
                          ->orWhere(function ($query) use ($rental) {
                              $query->where('start_time', '<=', $rental->start_time)
                                    ->where('end_time', '>=', $rental->end_time);
                          });
                })->exists();

            if ($conflict) {
                return throw new \Exception('The skate park is already rented for the given time period.');
            }
        });
    }

    public function skatePark()
    {
        return $this->belongsTo(SkatePark::class);
    }
}