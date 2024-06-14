<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Do delete storage disk
     */
    private function cleanupDisk()
    {
        $directory = storage_path('app/public');

        foreach (File::allFiles($directory) as $file) {
            File::delete($file);
        }
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        # Cleanup the storage folder
        $this->cleanupDisk();

        # Seed the data
        $this->call([
            IndonesianRegionProvinceSeeder::class,
            IndonesianRegionRegencySeeder::class,
            IndonesianRegionDistrictSeeder::class,
            IndonesianRegionVillageSeeder::class,

            CouncilCategorySeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
