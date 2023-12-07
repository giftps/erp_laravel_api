<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberActivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data_array = explode("T", $this->created_at);
        return [
            'id' => $this->id,
            'attributes' => [
                'description' => $this->description,
                'created_at' => $data_array[0]
            ]
        ];
    }
}
