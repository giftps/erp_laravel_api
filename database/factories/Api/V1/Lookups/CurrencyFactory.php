<?php

namespace Database\Factories\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'symbol' => 'K',
            'code' => 'ZMW',
            'description' => 'Zambian Kwacha'
        ];
    }
}
