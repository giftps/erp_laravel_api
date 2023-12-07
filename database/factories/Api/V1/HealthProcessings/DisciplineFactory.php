<?php

namespace Database\Factories\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discipline>
 */
class DisciplineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => time(),
            'description' => $this->faker->name(),
            'used_for' => 'individual',
            'is_hospital' => 0,
            'status' => 'active'
        ];
    }
}
