<?php

namespace App\Http\Resources\Api\V1\Preauthorisations;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseNumbersResource extends JsonResource
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
                'case_number' => $this->case_number
            ]
        ];
    }
}
