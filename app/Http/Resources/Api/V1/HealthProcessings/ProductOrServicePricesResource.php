<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Lookups\ClaimCodesResource;

class ProductOrServicePricesResource extends JsonResource
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
                'tariff_code' => $this->tariff_code,
                'claim_code' => $this->claimCode->code,
                'service_type' => $this->serviceType->name,
                'name' => $this->name,
                'amount' => $this->amount
            ],
            'claim_code_id' => $this->claimCode ? $this->claimCode->id : null,
            'service_type_id' => $this->serviceType ? $this->serviceType->service_type_id : null
        ];
    }
}
