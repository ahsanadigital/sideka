<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'dkd'],
            ['name' => 'dkc'],
            ['name' => 'dkr'],
        ])->each(fn($items) => Role::create($items));
    }
}
