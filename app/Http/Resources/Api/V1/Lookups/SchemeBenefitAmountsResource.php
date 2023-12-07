<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class SchemeBenefitAmountsResource extends JsonResource
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
                'scheme_option_id' => $this->scheme_option_id,
                'benefit_option_id' => $this->benefit_option_id,
                'limit_amount' => $this->limit_amount
            ],
        ];
    }
}
