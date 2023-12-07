<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class DisciplinesResource extends JsonResource
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
            'discipline_id' => $this->discipline_id,
            'attributes' => [
                'code' => $this->code,
                'description' => $this->description,
                'is_hospital' => $this->is_hospital,
                'age' => $this->age,
                'gender' => $this->gender,
                'prescribed_amount' => $this->prescribed_amount,
                'status' => $this->status
            ],
            'service_providers' => ServiceProvidersResource::collection($this->whenLoaded('serviceProviders')),
            'service_codes' => ServiceCodesResource::collection($this->whenLoaded('serviceCodes')),
        ];
    }
}
