<?php

namespace Database\Factories\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Claim>
 */
class ClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'preauthorisation_id' => 1,
            'claim_number' => time(),
            'claims_logs_id' => 1,
            'member_id' => 1,
            'auth_number' => time(),
            'invoice_number' => time()
        ];
    }
}
