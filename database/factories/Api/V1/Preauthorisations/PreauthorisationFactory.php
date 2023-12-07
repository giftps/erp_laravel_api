<?php

namespace Database\Factories\Api\V1\Preauthorisations;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preauthorisation>
 */
class PreauthorisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'case_number_id' => 1,
            'auth_code' => time(),
            'appointment_date' => '2023-03-03',
            'admission_date' => '2023-03-03',
            'estimated_discharge_date' => '2023-03-03',
            'complaint' => 'Headache',
            'diagnosis' => 'Headache',
            'total_amount' => 200,
            'amount_in_dollar' => 10,
            'ses_pay_amount' => 200,
            'member_pay_amount' => 0,
            'quotation_url' => 'localhost',
            'gop_sent' => 1,
            'status' => 'active'
        ];
    }
}
