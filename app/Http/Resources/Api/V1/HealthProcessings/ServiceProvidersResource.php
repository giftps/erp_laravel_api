<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProvidersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!$this->relationLoaded('discipline')){
            return [
                'service_provider_id' => $this->service_provider_id,
                'attributes' => [
                    'provider_type' => $this->provider_type,
                    'practice_number' => $this->practice_number,
                    'name' => $this->name,
                    'discipline_name' => $this->discipline->description,
                    'activation_date' => $this->activation_date,
                    'end_date' => $this->end_date,
                    'pay_currency' => $this->payCurrency?->code,
                    'receive_currency' => $this->receiveCurrency?->code,
                    'country' => $this->country,
                    'street' => $this->street,
                    'tier_level' => $this->tier_level,
                    'status' => $this->status
                ],
            ];
        }else{
            return [
                'service_provider_id' => $this->service_provider_id,
                'attributes' => [
                    'practice_number' => $this->practice_number,
                    'name' => $this->name,
                    'discipline_name' => $this->discipline->description,
                    'activation_date' => $this->activation_date,
                    'end_date' => $this->end_date,
                    'mobile_number' => $this->mobile_number,
                    'email' => $this->email,
                    'street' => $this->street,
                    'area' => $this->area,
                    'province' => $this->province,
                    'country' => $this->country,
                    'practice_number' => $this->practice_number,
                    'is_group_practice' => $this->is_group_practice,
                    'provider_category' => $this->provider_category,
                    'provider_type' => $this->provider_type,
                    'is_ses_network_provider' => $this->is_ses_network_provider,
                    'sla' => $this->sla,
                    'payment_term_days' => $this->payment_term_days,
                    'discount' => $this->discount,
                    'tier_level' => $this->tier_level,
                    'pay_currency' => $this->payCurrency?->code,
                    'receive_currency' => $this->receiveCurrency?->code,
                    'is_ses_network_provider' => $this->is_ses_network_provider,
                    'status' => $this->status
                ],
                'pay_currency_id' => $this->pay_currency_id,
                'receive_currency_id' => $this->receive_currency_id,
                'discipline' => new DisciplinesResource($this->discipline),
                'contact_persons' => ServiceProviderContactsResource::collection($this->whenLoaded('contactPerson'))
            ];
        }
    }
}
