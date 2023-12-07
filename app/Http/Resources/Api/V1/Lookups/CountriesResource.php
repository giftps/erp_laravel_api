<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

class CountriesResource extends JsonResource
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
            'country_id' => $this->id,
            'attributes' => [
                "country_code" => $this->country_code,
                "name" => $this->name,
                "currency_code" => $this->currency_code,
                "population" => $this->population,
                "capital" => $this->capital,
                "continent" => $this->continent
            ],
            'provinces' => ProvincesResource::collection($this->whenLoaded('provinces')),
            'cities' => CitiesResource::collection($this->whenLoaded('cities'))
        ];
    }
}
