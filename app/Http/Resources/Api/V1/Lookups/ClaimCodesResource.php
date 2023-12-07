<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class ClaimCodesResource extends JsonResource
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
            'claim_code_id' => $this->id,
            'attributes' => [
                'code' => $this->code,
                'description' => $this->description,
                'is_hospital' => $this->is_hospital,
                'age' => $this->age,
                'gender' => $this->gender,
                'needs_preauth' => $this->needs_preauth,
                'status' => $this->status
            ],
            'benefit' => new BenefitOptionsResource($this->benefit)
        ];
    }
}
