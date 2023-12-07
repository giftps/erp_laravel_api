<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorFlagTypesResource extends JsonResource
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
                'description' => $this->description
            ]
        ];
    }
}
