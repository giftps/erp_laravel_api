<?php

namespace App\Http\Resources\Api\V1\UserAccess;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
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
            'role_id' => $this->role_id,
            'type' => 'roles',
            'attributes' => [
                'name' => $this->name
            ],
            'permissions' => PermissionsResource::collection($this->permission)
        ];
    }
}
