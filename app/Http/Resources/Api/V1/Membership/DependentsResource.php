<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class DependentsResource extends JsonResource
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
            'dependent_id' => $this->dependent_id,
            'attributes' => [
                'member_number' => $this->member_number,
                'first_name' => $this->first_name,
                'surname' => $this->last_name,
                'email' => $this->email,
                'nrc_or_passport_number' => $this->nrc_or_passport_number,
                'dob' => $this->dob,
                'sex' => $this->sex,
                'relationship' => $this->relationship,
                'is_main_member' => $this->is_main_member,
                'has_sporting_activities' => $this->has_sporting_activities,
                'sporting_activity_details' => $this->sporting_activity_details,
                'weight' => $this->weight,
                'height' => $this->height
            ],
            'main_member' => new MainMembersResource($this->whenLoaded('mainMember')),
            'medical_history' => MedicalHistoriesResource::collection($this->whenLoaded('medicalHistory')),
            'dependent_doctor' => new FamilyMemberDoctorsResource($this->whenLoaded('familyMemberDoctor'))
        ];
    }
}
