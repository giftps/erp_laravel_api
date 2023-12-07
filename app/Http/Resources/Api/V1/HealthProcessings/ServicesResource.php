<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
            'service_id' => $this->service_id,
            'attributes' => [
                'name' => $this->name,
                'age' => $this->age,
                'gender' => $this->gender,
                'prescribed_amount' => $this->prescribed_amount
            ],
            'service_providers' => ServiceProvidersResource::collection($this->whenLoaded('serviceProviders'))
        ];
    }
}
