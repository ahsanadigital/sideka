<?php

namespace Database\Seeders;

use App\Enums\CouncilCategoryEnum;
use App\Helpers\ColorHelper;
use App\Models\CouncilCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouncilCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(CouncilCategoryEnum::cases() as $councilCategory) {
            CouncilCategory::create([
                'name' => $councilCategory->label(),
                'slug' => $councilCategory->value,
                'color' => ColorHelper::generateRandomColor(),
                'active' => true,
            ]);
        }
    }
}
