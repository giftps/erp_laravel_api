<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchemeAdministratorsResource extends JsonResource
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
            'scheme_admin_id' => $this->scheme_admin_id,
            'attributes' => [
                'is_new_application' => $this->is_new_application,
                'is_individual_account' => $this->is_individual_account,
                'account_name' => $this->account_name,
                'title' => $this->title,
                'first_name' => $this->first_name,
                'surname' => $this->surname,
                'dob' => $this->dob,
                'nationality' => $this->nationality,
                'sex' => $this->sex,
                'postal_address' => $this->postal_address,
                'postal_code' => $this->postal_code,
                'telephone_number' => $this->telephone_number,
                'mobile_number' => $this->mobile_number,
                'email1' => $this->email1,
                'email2' => $this->email2,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'tpin' => $this->tpin
            ],
            'main_member' => MainMembersResource::collection($this->whenLoaded('mainMembers'))
        ];
    }
}
