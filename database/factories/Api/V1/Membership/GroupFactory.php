<?php

namespace Database\Factories\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'group_name' => $this->faker->name(),
            'code' => "CDE",
            'office_number' => time(),
            'join_date' => date('Y-m-d'),
            'group_type' => 'INDV',
            'status' => 'active'
        ];
    }
}
