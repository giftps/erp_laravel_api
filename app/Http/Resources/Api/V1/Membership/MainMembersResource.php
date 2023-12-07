<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Lookups\SchemeTypesResource;
use App\Http\Resources\Api\V1\Sales\BrokersResource;

class MainMembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'main_member_id' => $this->main_member_id,
            'attributes' => [
                'scheme' => $this->schemeOption ? $this->schemeOption->name : null,
                'family_code' => $this->family_code,
                'member_type' => $this->member_type,
                'title' => $this->title,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'other_names' => $this->other_names,
                'dob' => $this->dob,
                'sex' => $this->sex,
                'nationality' => $this->nationality,
                'nrc_or_passport_no' => $this->nrc_or_passport_no,
                'occupation' => $this->occupation,
                'email' => $this->email,
                'work_number' => $this->work_number,
                'mobile_number' => $this->mobile_number,
                'physical_address' => $this->physical_address,
                'postal_address' => $this->postal_address,
                'nearest_city' => $this->nearest_city,
                'postal_code' => $this->postal_code,
                'subscription_type' => $this->subscription_type,
                'in_holding_tank' => $this->in_holding_tank,
                'status' => $this->status,
                'application_date' => $this->application_date,
                'join_date' => $this->join_date,
                'benefit_start_date' => $this->benefit_start_date,
                'end_date' => $this->end_date,
                'suspension_date' => $this->suspension_date,
                'suspension_lifted_date' => $this->suspension_lifted_date,
                'limit_start_date' => $this->limit_start_date,
                'limit_end_date' => $this->limit_end_date,
                'next_renewal_date' => $this->next_renewal_date,
                'has_funeral_cash_benefit' => $this->has_funeral_cash_benefit,
                'funeral_benefit_start_date' => $this->funeral_benefit_start_date,
                'funeral_benefit_end_date' => $this->funeral_benefit_end_date,
                'beneficiary_name' => $this->beneficiary_name,
                'beneficiary_mobile_number' => $this->beneficiary_mobile_number,
                'beneficiary2_name' => $this->beneficiary2_name,
                'beneficiary2_mobile_number' => $this->beneficiary2_mobile_number,
                'has_sports_loading' => $this->has_sports_loading,
                'sports_loading_start_date' => $this->sports_loading_start_date,
                'sports_loading_end_date' => $this->sports_loading_end_date,
                'sporting_activity' => $this->sporting_activity,
            ],
            'broker' => new BrokersResource($this->whenLoaded('broker')),
            'scheme_option' => new SchemeTypesResource($this->whenLoaded('schemeOption')),
            'scheme_type' => new SchemeTypesResource($this->whenLoaded('schemeType')),
            'dependents' => DependentsResource::collection($this->whenLoaded('dependents')),
        ];
    }
}
