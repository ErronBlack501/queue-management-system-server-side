<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Counter;
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
            'counter_number' => null,
            'counter_status' => 'closed',
            'service_id' => Service::factory(),
            'user_id' => User::factory(),
        ];
    }
}
