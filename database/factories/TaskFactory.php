<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
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
            'customer_id' => User::all()->random()->id,
            'price' => $this->faker->randomNumber(),
            'deadline' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(TaskStatuses::allStatuses())
        ];
    }
}
