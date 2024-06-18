<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'place' => $this->faker->city(),
            'notes' => $this->faker->text(),
            'users_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
        ];
    }
}
