<?php

namespace App\Http\Resources\Api\V1\Claims;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Api\V1\HealthProcessings\Tariff;

class ClaimLineItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tariff = Tariff::where('code', '=', $this->tariff_code)->first();
        return [
            'id' => $this->id,
            'claim_id' => $this->claim_id,
            'claim_code' => $this->claim_code,
            'tariff_code' => $this->tariff_code,
            'tariff_description' => $tariff->description,
            'diagnosis' => $this->diagnosis,
            'icd10' => $this->icd10,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'assessed_amount' => $this->assessed_amount,
            'rejected_amount' => $this->rejected_amount,
            'comment' => $this->comment,
            'amount_in_dollar' => $this->amount_in_dollar,
            'date_of_service' => $this->date_of_service
        ];
    }
}
