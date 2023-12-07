<?php

namespace Database\Factories\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClaimsLog>
 */
class ClaimsLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'batch_number' => time(),
            'date_received' => '2023-03-03',
            'statement_month' => 'January',
            'statement_total' => 5000,
            'number_of_invoices' => 5,
            'receiver_id' => 2,
            'due_date' => '2024-04-04',
            'status' => 'Logged'
        ];
    }
}
