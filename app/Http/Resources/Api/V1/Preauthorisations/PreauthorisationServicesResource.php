<?php

namespace App\Http\Resources\Api\V1\Preauthorisations;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Api\V1\Lookups\Currency;

use App\Models\Api\V1\HealthProcessings\Tariff;

class PreauthorisationServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tariff = Tariff::where('code', '=', $this->price->tariff->code)->first();
        
        return [
            'id' => $this->id,
            'attributes' => [
                'description' => $this->price->description,
                'currency' => $this->price?->serviceProvider->receiveCurrency->code,
                'amount' => $this->amount,
                'amount_in_dollar' => $this->amount_in_dollar,
                'ses_pay_amount' => $this->ses_pay_amount,
                'member_pay_amount' => $this->member_pay_amount,
                'claim_code' => $this->price->tariff->claimCode?->code,
                'tariff_code' => $tariff?->code,
                'tariff_description' => $tariff?->description
            ]
        ];
    }
}
