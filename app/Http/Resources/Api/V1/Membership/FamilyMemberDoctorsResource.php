<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMemberDoctorsResource extends JsonResource
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
            'family_member_doctor_id' => $this->family_member_doctor_id,
            'attributes' => [
                'name' => $this->name,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'treatment_length' => $this->treatment_length
            ],
        ];
    }
}
