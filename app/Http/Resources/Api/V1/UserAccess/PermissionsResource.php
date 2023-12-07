<?php

namespace App\Http\Resources\Api\V1\UserAccess;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionsResource extends JsonResource
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
            'permission_id' => $this->id,
            'attributes' => [
                'module' => $this->module->name,
                'role' => $this->role->name,
                'can_add' => $this->can_add,
                'can_edit' => $this->can_edit,
                'can_delete' => $this->can_delete
            ],
        ];
    }
}
