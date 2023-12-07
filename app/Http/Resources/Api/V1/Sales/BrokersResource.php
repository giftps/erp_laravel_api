<?php

namespace App\Http\Resources\Api\V1\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Membership\MembersResource;

class BrokersResource extends JsonResource
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
            'broker_id' => $this->broker_id,
            'attributes' => [
                'code' => $this->code,
                'title' => $this->title,
                'first_name' => $this->first_name,
                'surname' => $this->surname,
                'id_number' => $this->id_number,
                'address1' => $this->address1,
                'address2' => $this->address2,
                'city' => $this->city,
                'office_number' => $this->office_number,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'active_date' => $this->active_date,
                'inactive_date' => $this->inactive_date,
                'status' => $this->status
            ],
            'broker_house' => new BrokerHousesResource($this->whenLoaded('brokerHouse')),
        ];
    }
}
