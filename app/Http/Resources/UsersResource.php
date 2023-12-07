<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\UserAccess\RolesResource;

class UsersResource extends JsonResource
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
            'user_id' => $this->user_id,
            'type' => 'users',
            'attributes' => [
                'unique_id' => $this->unique_id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'is_active' => $this->is_active,
                'email_verified_at' => $this->email_verified_at,
                'phone_number' => $this->phone_number,
                'password_expiry_date' => $this->password_expiry_date,
                'is_password_expired' => $this->password_expiry_date <= date('Y-m-d') ? true : false,
                'designation' => $this->designation,
                'department' => $this->department?->name,
                'profile_picture' => $this->profile_picture
            ],
            'role' => new RolesResource($this->role)
        ];
    }
}
