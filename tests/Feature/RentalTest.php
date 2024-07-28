<?php

use App\Models\SkatePark;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a rental', function () {
    $skatePark = SkatePark::create([
        'name' => 'Test Park',
        'description' => 'Test Description',
        'location' => 'Test Location',
    ]);

    $rental = Rental::create([
        'skate_park_id' => $skatePark->id,
        'renter_name' => 'John Cena',
        'start_time' => now(),
        'end_time' => now()->addHours(1),
    ]);

    expect($rental)->toBeInstanceOf(Rental::class);
    expect($rental->renter_name)->toBe('John Cena');
    expect($rental->skatePark)->toBeInstanceOf(SkatePark::class);
    expect($rental->skatePark->id)->toBe($skatePark->id);
});

it('ensures skate park deletion cascades to rentals', function () {
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

    $skatePark->delete();

    expect(Rental::find($rental->id))->toBeNull();
});