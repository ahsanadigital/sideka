<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Helpers\ConsoleHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Do delete storage disk
     */
    private function cleanupDisk()
    {
        $directory = storage_path('app/public');

        // Ensure the directory exists before attempting to clean it
        if (File::exists($directory)) {
            // Recursively delete files and directories
            File::deleteDirectory($directory, $preserve = false);

            // Recreate the directory to keep the structure intact
            File::makeDirectory($directory);

            // Show the success info
            ConsoleHelper::success("Successfuly cleanup the storage");
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
