<?php

namespace App\Http\Resources\Api\V1\Financials;

use Illuminate\Http\Resources\Json\JsonResource;

class PremiumPaymentsResource extends JsonResource
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
            'family_id' => $this->family_id,
            'attributes' => [
                'receipt_number' => $this->receipt_number,
                'principal_member_number' => $this->family->members()->where('dependent_code', '=', '00')->first()?->member_number,
                'family_code' => $this->family->family_code,
                'currency' => $this->currency,
                'tax' => $this->tax,
                'amount' => $this->amount,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status
            ]
        ];
    }
}
