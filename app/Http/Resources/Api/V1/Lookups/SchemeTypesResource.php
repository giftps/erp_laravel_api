<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class SchemeTypesResource extends JsonResource
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
            'scheme_type_id' => $this->id,
            'attributes' => [
                'code' => $this->code,
                'identifier' => $this->identifier,
                'description' => $this->description
            ]
        ];
    }
}
