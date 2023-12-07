<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

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
                'used_for' => $this->used_for,
                'is_hospital' => $this->is_hospital,
                'status' => $this->status
            ]
        ];
    }
}
