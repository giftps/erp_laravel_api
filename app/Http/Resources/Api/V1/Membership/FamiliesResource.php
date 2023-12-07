<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Sales\BrokersResource;
use App\Http\Resources\Api\V1\Membership\MembersResource;

class FamiliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $has_sports_loading = null;
        $sporting_activity = null;
        $principal = $this->members()->where('dependent_code', '=', '00')->first();

        if($principal){
            $has_sports_loading = $principal->has_sports_loading;
            $sporting_activity = $principal->sporting_activity;
        }

        return [
            'id' => $this->id,
            'attributes' => [
                'subscription_period_id' => $this->subscription_period_id,
                'group_type_id' => $this->group_type_id,
                'family_code' => $this->family_code,
                'member_type' => $this->member_type,
                'physical_address' => $this->physical_address,
                'postal_address' => $this->postal_address,
                'nearest_city' => $this->nearest_city,
                'province' => $this->province,
                'postal_code' => $this->postal_code,
                'subscription_type' => $this->subscription_type,
                'in_holding_tank' => $this->in_holding_tank,
                'status' => $this->status,
                'application_date' => $this->application_date,
                'nationality' => $this->nationality,
                'benefit_start_date' => $this->benefit_start_date,
                'benefit_end_date' => $this->benefit_end_date,
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
                'has_sports_loading' => $has_sports_loading,
                'sports_loading_start_date' => $this->sports_loading_start_date,
                'sports_loading_end_date' => $this->sports_loading_end_date,
                'sporting_activity' => $sporting_activity,
                'registration_stage' => $this->registration_stage
            ],
            'scheme_details' => new FamilySchemeDetailsResource($this->whenLoaded('familySchemeDetails')),
            'broker' => new BrokersResource($this->whenLoaded('broker')),
            'members' => MembersResource::collection($this->whenLoaded('members'))
        ];
    }
}
