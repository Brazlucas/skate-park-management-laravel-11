<?php

use App\Models\SkatePark;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a skate park', function () {
    $skatePark = SkatePark::create([
        'name' => 'Test Park',
        'description' => 'Test Description',
        'location' => 'Test Location',
    ]);

    expect($skatePark)->toBeInstanceOf(SkatePark::class);
    expect($skatePark->name)->toBe('Test Park');
});

it('can create a rental for a skate park', function () {
    $skatePark = SkatePark::create([
        'name' => 'Test Park',
        'description' => 'Test Description',
        'location' => 'Test Location',
    ]);

    $rental = Rental::create([
        'skate_park_id' => $skatePark->id,
        'renter_name' => 'John Cena',
        'start_time' => now(),
        'end_time' => now()->addHours(2),
    ]);

    expect($rental)->toBeInstanceOf(Rental::class);
    expect($rental->skate_park_id)->toBe($skatePark->id);
    expect($rental->skatePark->id)->toBe($skatePark->id);
});