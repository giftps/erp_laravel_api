<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LimitsResource extends JsonResource
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
            'limit_id' => $this->limit_id,
            'attributes' => [
                'code' => $this->code,
                'description' => $this->description
            ],
            'plan_types' => PlanTypesResource::collection($this->whenLoaded('planTypes'))
        ];
    }
}
