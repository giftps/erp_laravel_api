<?php

namespace Database\Factories\Api\V1\Sales;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrokerHouse>
 */
class BrokerHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'broker_type_id' => 1,
            'user_id' => 1,
            'name' => 'SES Broker house',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'city' => 'City',
            'code' => 'CDE',
            'contact_person_name' => $this->faker->name(),
            'contact_person_email' => $this->faker->email(),
            'office_number' => '090984543',
            'mobile_number' => '09099343234',
            'website_address' => 'Address',
            'active_date' => date('Y-m-d'),
            'status' => 'active'
        ];
    }
}
