<?php

namespace App\Http\Resources\Api\V1\UserAccess;

use Illuminate\Http\Resources\Json\JsonResource;

class ModulesResource extends JsonResource
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
            'module_id' => $this->module_id,
            'attributes' => [
                'name' => $this->name
            ]
        ];
    }
}
