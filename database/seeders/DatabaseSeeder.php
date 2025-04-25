<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use App\Models\SkatePark;
use App\Models\Rental;
use App\Models\Invoice;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Lucas ADM',
            'email' => 'lukkascomics@gmail.com',
            'password' => bcrypt('97322607l'),
            'address' => 'Rua Principal, 123',
            'phone' => '11999999999',
            'is_admin' => true,
            'notifications' => ['email' => true, 'sms' => false],
        ]);

        $user = User::factory()->create([
            'name' => 'Lucas Usuário',
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

        $location = Location::create([
            'city' => 'Guarulhos',
            'state' => 'SP',
        ]);

        $skatePark = SkatePark::create([
            'name' => 'Pista do Ibirapuera',
            'description' => 'Pista tradicional com ótima estrutura para manobras.',
            'location_id' => $location->id,
            'image' => 'https://www.princeofstreets.com.br/blog/wp-content/uploads/2022/12/Foto-1-Vans-Skate-Park-1024x791.jpg',
        ]);

        // $startTime = Carbon::tomorrow()->setHour(10)->setMinute(0);
        // $endTime = Carbon::tomorrow()->setHour(12)->setMinute(0);
        // $rentValue = 200;

        // $rental = Rental::create([
        //     'skate_park_id' => $skatePark->id,
        //     'renter_name' => $user->name,
        //     'renter_id' => $user->id,
        //     'start_time' => $startTime,
        //     'end_time' => $endTime,
        //     'rent_value' => $rentValue,
        // ]);

        // $month = $startTime->format('Y-m');
        
        // $invoice = Invoice::firstOrCreate(
        //     [
        //         'user_id' => $user->id,
        //         'month' => $month,
        //     ],
        //     [
        //         'total' => 0,
        //         'status' => 'pending',
        //     ]
        // );

        // $invoice->total += $rental->rent_value;
        // $invoice->save();
    }
}
