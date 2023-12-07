<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderPaymentDetailsResource extends JsonResource
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
                'bank' => $this->bank,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'branch_code' => $this->branch_code,
                'swift_code' => $this->swift_code
            ],
            'service_provider' => new ServiceProvidersResource($this->whenLoaded('serviceProvider'))
        ];
    }
}
