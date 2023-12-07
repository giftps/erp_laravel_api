<?php

namespace App\Http\Resources\Api\V1\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Lookups\BrokerTypesResource;

class BrokerHousesResource extends JsonResource
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
            'broker_house_id' => $this->broker_house_id,
            'attributes' => [
                'name' => $this->name,
                'address1' => $this->address1,
                'address2' => $this->address2,
                'city' => $this->city,
                'code' => $this->code,
                'contact_person_name' => $this->contact_person_name,
                'contact_person_email' => $this->contact_person_email,
                'office_number' => $this->office_number,
                'mobile_number' => $this->mobile_number,
                'website_address' => $this->website_address,
                'active_date' => $this->active_date,
                'inactive_date' => $this->inactive_date,
                'status' => $this->status
            ],
            'broker_type' => new BrokerTypesResource($this->brokerType),
            'brokers' => BrokersResource::collection($this->whenLoaded('brokers'))
        ];
    }
}
