<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrenciesResource extends JsonResource
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
            'currency_id' => $this->id,
            'attributes' => [
                'symbol' => $this->symbol,
                'code' => $this->code,
                'description' => $this->description
            ]
        ];
    }
}
