<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Counter>
 */
class CounterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'counter_number' => fake()->numerify(),
            'counter_status' => fake()->randomElement(['idle', 'serving', 'closed', 'suspended']),
            'service_id' => Service::factory(),
        ];
    }
}
