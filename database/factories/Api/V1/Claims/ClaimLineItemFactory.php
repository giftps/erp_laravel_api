<?php

namespace Database\Factories\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClaimLineItem>
 */
class ClaimLineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tariff_code' => time(),
            'claim_code' => time(),
            'diagnosis' => $this->faker->name(),
            'icd10' => 'uere',
            'currency' => 'USD',
            'amount' => 2000,
            'date_of_service' => date('Y-m-d')
        ];
    }
}
