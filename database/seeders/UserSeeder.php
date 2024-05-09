<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->assignRole('dkd')->create([
            'fullname' => 'Admin DKD Jatim',
            'email' => 'admin@dkdjatim.or.id',
            'password' => 'password@dkdjatim2024'
        ]);

        User::factory(20)->assignRole('dkc')->create();
        User::factory(20)->assignRole('dkr')->create();
    }
}
