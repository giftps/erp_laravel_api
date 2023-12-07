<?php

namespace Database\Factories\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrokerType>
 */
class BrokerTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'SES-Broker'
        ];
    }
}
