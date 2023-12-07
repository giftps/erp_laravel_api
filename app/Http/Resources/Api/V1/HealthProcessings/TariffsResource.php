<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class TariffsResource extends JsonResource
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
                'code' => $this->code,
                'claim_code' => $this->claimCode?->code,
                'discipline_code' => $this->discipline?->code,
                'discipline_id' => $this->discipline?->id,
                'description' => $this->description,
                'tariff_group' => $this->tariff_group,
                'effective_date' => $this->effective_date,
                'practice_type' => $this->practice_type,
                'ses_rate' => $this->ses_rate,
                'code' => $this->code
            ],
            // 'discipline' => new DisciplinesResource($this->discipline)
        ];
    }
}
