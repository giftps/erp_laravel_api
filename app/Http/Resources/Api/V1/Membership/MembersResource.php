<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Membership\Group;

use App\Http\Resources\Api\V1\Membership\MembersResource;

class MembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->relationLoaded('family')){
            // Detailed information about the member with the relationships.
            return $this->memberDetails();
        }else{
            return $this->members();
        }
    }

    public function memberDetails(){
        $other_members = Member::where('family_id', '=', $this->family->id)->get();
            $age = date_diff(date_create($this->dob), date_create(date('Y-m-d')));
            $member_age = $age->format('%y');
            return [
                'member_id' => $this->member_id,
                'family_id' => $this->family_id,
                'attributes' => [
                    'family_code' => $this->family->family_code,
                    'scheme_option_id' => $this->scheme_option_id,
                    'scheme_type_id' => $this->scheme_type_id,
                    'member_number' => $this->member_number,
                    'dependent_code' => $this->dependent_code,
                    'title' => $this->title,
                    'initials' => mb_strtoupper(mb_substr($this->first_name, 0, 1)),
                    'first_name' => $this->first_name,
                    'other_names' => $this->other_names,
                    'last_name' => $this->last_name,
                    'occupation' => $this->occupation,
                    'group_type' => $this->family->groupType->name,
                    'scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                    'dob' => $this->dob,
                    'age' => $member_age,
                    'gender' => $this->gender,
                    'nrc_or_passport_no' => $this->nrc_or_passport_no,
                    'marital_status' => $this->marital_status,
                    'language' => $this->language,
                    'scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                    'member_type' => $this->dependent_code === "00" ? "Principal" : "Dependent",
                    'email' => $this->email,
                    'resign_code' => $this->resign_code,
                    'work_number' => $this->work_number,
                    'mobile_number' => $this->mobile_number,
                    'physical_address' => $this->family->physical_address,
                    'postal_address' => $this->family->postal_address,
                    'postal_code' => $this->family->postal_code,
                    'nearest_city' => $this->family->nearest_city,
                    'province' => $this->family->province,
                    "is_chronic" => $this->is_chronic,
                    "sage_account" => $this->sage_account,
                    "status" => $this->is_resigned == 1 ? "resigned" : $this->family->status,
                    "join_date" => $this->join_date,
                    "weight" => $this->weight,
                    "height" => $this->height,
                    "registration_stage" => $this->family?->registration_stage
                ],
                'scheme_details' => [
                    'current_scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                    'subscription_type' => $this->family->subscription_period_id ? SubscriptionPeriod::find($this->family->subscription_period_id)->name : null,
                    'member_type' => $this->dependent_code == "00" ? "Principal" : "Dependant",
                    'scheme_type' => $this->scheme_option_id ? SchemeOption::find($this->scheme_option_id)->member_types : null,
                    'group' => $this->family->group_id ? Group::find($this->family->group_id)->group_name : null,
                    'scheme_status' => SchemeOption::find($this->scheme_option_id) && SchemeOption::find($this->scheme_option_id)->is_active == 1 ? 'active' : 'inactive',
                    'application_date' => $this->family->application_date,
                    'benefit_start_date' => $this->family->benefit_start_date,
                    'benefit_end_date' => $this->family->benefit_end_date,
                    'join_date' => $this->join_date,
                    'suspension_date' => $this->family->suspension_date,
                    'suspension_end_date' => $this->family->suspension_lifted_date,
                    'next_renewal_date' => $this->family->next_renewal_date,
                    'has_funeral_cash_benefit' => $this->family->has_funeral_cash_benefit,
                    'funeral_benefit_start_date' => $this->family->funeral_benefit_start_date,
                    'funeral_benefit_end_date' => $this->family->funeral_benefit_end_date,
                    'beneficiary_name' => $this->family->beneficiary_name,
                    'beneficiary_mobile_number' => $this->family->beneficiary_mobile_number,
                    'beneficiary2_name' => $this->family->beneficiary2_name,
                    'beneficiary2_mobile_number' => $this->family->beneficiary2_mobile_number,
                    'has_sports_loading' => $this->has_sports_loading,
                    'sports_loading_start_date' => $this->sports_loading_start_date,
                    'sports_loading_end_date' => $this->sports_loading_end_date,
                    'sporting_activity' => $this->sporting_activity
                ],
                // 'documents' => MemberDocumentsResource::collection($this->whenLoaded('documents')),
                'dependents' => $other_members ? MembersResource::collection($other_members) : $this->whenLoaded('family')
            ];
    }

    public function members(){
        $age = date_diff(date_create($this->dob), date_create(date('Y-m-d')));
        $member_age = $age->format('%y');
        // The basic information that is displayed in a table
        return [
            'member_id' => $this->member_id,
            'family_id' => $this->family?->family_id,
            'attributes' => [
                'family_code' => $this->family->family_code,
                'scheme_option_id' => $this->scheme_option_id,
                'scheme_type_id' => $this->scheme_type_id,
                'member_number' => $this->member_number,
                'dependent_code' => $this->dependent_code,
                'title' => $this->title,
                'initials' => mb_strtoupper(mb_substr($this->first_name, 0, 1)),
                'first_name' => $this->first_name,
                'other_names' => $this->other_names,
                'last_name' => $this->last_name,
                'occupation' => $this->occupation,
                'group_type' => $this->family->groupType->name,
                'scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                'dob' => $this->dob,
                'age' => $member_age,
                'gender' => $this->gender,
                'nrc_or_passport_no' => $this->nrc_or_passport_no,
                'marital_status' => $this->marital_status,
                'language' => $this->language,
                'scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                'member_type' => $this->dependent_code === "00" ? "Principal" : "Dependent",
                'email' => $this->email,
                'resign_code' => $this->resign_code,
                'work_number' => $this->work_number,
                'mobile_number' => $this->mobile_number,
                'physical_address' => $this->family->physical_address,
                'postal_address' => $this->family->postal_address,
                'postal_code' => $this->family->postal_code,
                'nearest_city' => $this->family->nearest_city,
                'province' => $this->family->province,
                "sage_account" => $this->sage_account,
                "weight" => $this->weight,
                "height" => $this->height,
                "status" => $this->is_resigned == 1 ? "resigned" : $this->family->status,
                "join_date" => $this->join_date,
                "registration_stage" => $this->family?->registration_stage
            ],
        ];
    }
}
