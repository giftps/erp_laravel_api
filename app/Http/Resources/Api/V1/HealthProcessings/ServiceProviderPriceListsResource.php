<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderPriceListsResource extends JsonResource
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
                'description' => $this->description,
                'tariff_id' => $this->tariff_id,
                'tariff_code' => $this->tariff?->code,
                'year' => $this->year,
                'currency' => $this->serviceProvider->receiveCurrency?->code,
                'price' => $this->price
            ]
        ];
    }
}
