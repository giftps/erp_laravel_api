<?php

namespace Database\Factories\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Api\V1\Membership\Family;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'dependent_code' => '00',
            'member_number' => time(),
            'title' => 'MR',
            'initials' => 'I',
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'other_names' => 'None',
            'dob' => '1996-09-18',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'language' => 'English',
            'nrc_or_passport_no' => time(),
            'occupation' => 'Software Engineer',
            'relationship' => 'Husband',
            'email' => $this->faker->email(),
            'work_number' => time(),
            'mobile_number' => time(),
            'join_date' => date('Y-m-d'),
            'is_principal' => 1,
            'has_sports_loading' => 1,
            'sports_loading_start_date' => date('Y-m-d'),
            'sports_loading_end_date' => date('Y-m-d'),
            'sporting_activity' => 'Running',
            'weight' => 20,
            'height' => 20,
            
        ];
    }
}
