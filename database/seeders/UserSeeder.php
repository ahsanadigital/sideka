<?php

namespace Database\Seeders;

use App\Enums\RoleUserEnum;
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
        User::factory()->assignRole(RoleUserEnum::DKD->value)->create([
            'fullname' => 'Admin DKD Jatim',
            'email' => 'admin@dkdjatim.or.id',
            'password' => 'password@dkdjatim2024'
        ]);
        User::factory()->assignRole(RoleUserEnum::DKC->value)->create([
            'fullname' => 'DKC Ngawi',
            'email' => 'admin@pramuka.ngawikab.go.id',
            'password' => 'pramuka@kartonyono2024'
        ]);
    }
}
