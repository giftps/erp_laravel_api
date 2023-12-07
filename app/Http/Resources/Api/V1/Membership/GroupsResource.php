<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupsResource extends JsonResource
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
                'group_name' => $this->group_name,
                'code' => $this->code,
                'office_number' => $this->office_number,
                'nuit' => $this->nuit,
                'industry' => $this->industry,
                'group_size' => $this->group_size,
                'join_date' => $this->join_date,
                'website' => $this->website,
                'contact_person_name' => $this->contact_person_name,
                'contact_email' => $this->contact_email,
                'contact_phone_number' => $this->contact_phone_number,
                'status' => $this->status
            ]
        ];
    }
}
