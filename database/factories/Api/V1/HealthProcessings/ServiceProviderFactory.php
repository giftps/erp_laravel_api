<?php

namespace Database\Factories\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProvider>
 */
class ServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pay_currency_id' => 1,
            'receive_currency_id' => 1,
            'name' => $this->faker->name,
            'email' => $this->faker->email(),
            'mobile_number' => time(),
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'address3' => 'Address 3',
            'country' => 'Zambia',
            'practice_number' => time(),
            'is_group_practice' => 0,
            'provider_category' => $this->faker->name(),
            'provider_type' => 'hospital',
            'is_ses_network_provider' => 1,
            'sla' => 1,
            'payment_term_days' => 14,
            'discount' => 0,
            'tier_level' => 1,
            'activation_date' => date('Y-m-d'),
            'end_date' => '2024-04-04',
            'status' => 'active'
        ];
    }
}
