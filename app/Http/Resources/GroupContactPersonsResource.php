<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupContactPersonsResource extends JsonResource
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
            'contact_id' => $this->contact_id,
            'attributes' => [
                'name' => $this->name,
                'phone_number' => $this->phone_number,
                'email' => $this->email
            ]
        ];
    }
}
