<?php

namespace Database\Factories\Api\V1\Preauthorisations;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseNumber>
 */
class CaseNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'member_id' => 1,
            'service_provider_id' => 1,
            'case_number' => time()
        ];
    }
}
