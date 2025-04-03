<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Chorão Admin',
            'email' => 'lukkascomics@gmail.com',
            'password' => bcrypt('97322607l'),
            'address' => '123 Test St',
            'phone' => '123-456-7890',
            'is_admin' => true,
            'notifications' => [
                'email' => true,
                'sms' => false
            ],
        ]);

        User::factory()->create([
            'name' => 'Chorão Usuário',
            'email' => 'invadiumeupc123@hotmail.com',
            'password' => bcrypt('97322607l'),
            'address' => '123 Test St',
            'phone' => '123-456-7890',
            'is_admin' => false,
            'notifications' => [
                'email' => true,
                'sms' => false
            ],
        ]);
    }
}
