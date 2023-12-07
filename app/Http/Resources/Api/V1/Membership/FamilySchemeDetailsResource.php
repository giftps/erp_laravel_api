<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilySchemeDetailsResource extends JsonResource
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
            'id' => $this->id,
            'attributes' => [
                'subscription_period_id' => $this->subscription_period_id,
                'benefit_start_date' => $this->benefit_start_date,
                'benefit_end_date' => $this->benefit_end_date,
                'has_funeral_cash_benefit' => $this->has_funeral_cash_benefit,
                'funeral_benefit_start_date' => $this->funeral_benefit_start_date,
                'funeral_benefit_end_date' => $this->funeral_benefit_end_date,
                'beneficiary_name' => $this->beneficiary_name,
                'beneficiary_mobile_number' => $this->beneficiary_mobile_number,
                'beneficiary2_name' => $this->beneficiary2_name,
                'beneficiary2_mobile_number' => $this->beneficiary2_mobile_number
            ]
        ];
    }
}
