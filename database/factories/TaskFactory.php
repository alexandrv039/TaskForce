<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'city_id' => City::all()->random()->id,
            'price' => $this->faker->randomNumber(),
            'deadline' => $this->faker->dateTime(),
            'customer_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement(TaskStatuses::allStatuses()),
            'category' => Category::all()->random()->name,
        ];
    }
}
