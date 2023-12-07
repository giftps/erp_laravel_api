<?php

namespace Database\Factories\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchemeType>
 */
class SchemeTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => 'IS-001',
            'identifier' => 'TanzIndiv',
            'description' => 'Tanzanite Individual'
        ];
    }
}
