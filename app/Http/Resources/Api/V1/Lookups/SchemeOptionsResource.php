<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class SchemeOptionsResource extends JsonResource
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
            'scheme_option_id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'tier_level' => $this->tier_level,
                'member_types' => $this->member_types,
                'number_of_benefits' => count($this->benefitOptions),
                'is_active' => $this->is_active
            ],
            'benefits' => BenefitOptionsResource::collection($this->whenLoaded('benefitOptions'))
        ];
    }
}
