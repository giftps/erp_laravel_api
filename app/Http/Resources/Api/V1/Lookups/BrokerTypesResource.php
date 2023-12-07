<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Sales\BrokerHousesResource;

class BrokerTypesResource extends JsonResource
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
            'broker_type_id' => $this->broker_type_id,
            'attributes' => [
                'name' => $this->name
            ],
            'broker_houses' => BrokerHousesResource::collection($this->whenLoaded('brokerHouses'))
        ];
    }
}
