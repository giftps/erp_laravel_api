<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class ModusOperandisResource extends JsonResource
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
            'modus_operandi_id' => $this->id,
            'attributes' => [
                'description' => $this->description
            ]
        ];
    }
}
