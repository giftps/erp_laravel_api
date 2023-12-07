<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Lookups\SchemeOptionsResource;

class SchemeSubscriptionsResource extends JsonResource
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
                'scheme' => $this->scheme->name,
                'subscription_name' => $this->subscriptionPeriod->name,
                'currency_id' => $this->currency_id,
                'currency' => $this->currency->code,
                'amount' => $this->amount,
                'tax_percentage' => $this->tax_percentage
            ],
            'age_group' => new AgeGroupsResource($this->ageGroup)
        ];
    }
}
