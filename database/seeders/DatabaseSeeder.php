<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use App\Models\SkatePark;
use App\Models\Rental;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Chorão Admin',
            'email' => 'lukkascomics@gmail.com',
            'password' => bcrypt('97322607l'),
            'address' => 'Rua Principal, 123',
            'phone' => '11999999999',
            'is_admin' => true,
            'notifications' => ['email' => true, 'sms' => false],
        ]);

        $user = User::factory()->create([
            'name' => 'Chorão Usuário',
            'email' => 'invadiumeupc123@hotmail.com',
            'password' => bcrypt('97322607l'),
            'address' => 'Rua Secundária, 456',
            'phone' => '11988888888',
            'is_admin' => false,
            'notifications' => ['email' => true, 'sms' => false],
        ]);

        $location = Location::create([
            'city' => 'São Paulo',
            'state' => 'SP',
        ]);

        $skatePark = SkatePark::create([
            'name' => 'Pista do Ibirapuera',
            'description' => 'Pista tradicional com ótima estrutura para manobras.',
            'location_id' => $location->id,
            'image' => 'https://example.com/ibira.jpg',
        ]);

        $rental = Rental::create([
            'skate_park_id' => $skatePark->id,
            'renter_name' => $user->name,
            'renter_id' => $user->id,
            'start_time' => Carbon::tomorrow()->setHour(10)->setMinute(0),
            'end_time' => Carbon::tomorrow()->setHour(12)->setMinute(0),
        ]);
    }
}
