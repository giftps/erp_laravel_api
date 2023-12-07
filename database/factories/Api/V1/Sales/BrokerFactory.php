<?php

namespace Database\Factories\Api\V1\Sales;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Broker>
 */
class BrokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'broker_house_id' => 1,
            'code' => 'BR',
            'title' => 'Mr',
            'first_name' => $this->faker->name(),
            'surname' => $this->faker->name(),
            'nrc' => '211082/18/1',
            'id_number' => '89384342',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'city' => 'Lusaka',
            'office_number' => '098873432',
            'phone_number' => '90934234',
            'email' => $this->faker->email(),
            'active_date' => date('Y-m-d'),
            'status' => 'active'
        ];
    }
}
