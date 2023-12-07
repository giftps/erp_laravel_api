<?php

namespace Database\Factories\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchemeOption>
 */
class SchemeOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Tanzanite',
            'tier_level' => 1,
            'member_types' => 'corporate',
            'is_active' => 1
        ];
    }
}
