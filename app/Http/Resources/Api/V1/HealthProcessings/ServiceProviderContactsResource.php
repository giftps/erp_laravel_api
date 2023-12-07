<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderContactsResource extends JsonResource
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
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'contact_number' => $this->contact_number,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'designation' => $this->designation
            ],
            'service_provider' => new ServiceProvidersResource($this->whenLoaded('serviceProvider'))
        ];
    }
}
