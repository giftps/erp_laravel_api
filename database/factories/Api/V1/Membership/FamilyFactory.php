<?php

namespace Database\Factories\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Api\V1\Lookups\GroupType;
use App\Models\Api\V1\Membership\Group;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'family_code' => 'FMLY',
            'unique_linker' => '09343',
            'physical_address' => 'Physical Address',
            'postal_address' => 'Postal Address',
            'postal_code' => '090343',
            'nearest_city' => 'Lusaka',
            'status' => 'active',
            'nationality' => 'Zambian',
            'application_date' => date('Y-m-d'),
            'next_renewal_date' => '2024-04-04',
            'in_holding_tank' => 0,
            'benefit_start_date' => date('Y-m-d'),
            'benefit_end_date' => '2024-04-04',
            'has_funeral_cash_benefit' => 1,
            'is_underwritten' => 1,
            'underwriting_accepted' => 1,
            'is_invoice_accepted' => 1,
            'funeral_benefit_start_date' => date('Y-m-d'),
            'funeral_benefit_end_date' => '2024-04-04',
            'beneficiary_name' => 'Enock Soko',
            'beneficiary_mobile_number' => time(),
            'registration_stage' => 'completed'
        ];
    }
}
