<?php

namespace App\Http\Resources\Api\V1\HealthProcessings;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderDocumentsResource extends JsonResource
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
                'name' => $this->name,
                'url' => $this->url,
                'created_at' => $this->created_at
            ]
        ];
    }
}
