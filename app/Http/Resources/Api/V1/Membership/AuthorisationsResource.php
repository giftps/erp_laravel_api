<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UsersResource;

class AuthorisationsResource extends JsonResource
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
            'authorisation_id' => $this->authorisation_id,
            'attributes' => [
                'auth_code' => $this->auth_code,
                'claim_code' => $this->claimCode->code,
                'service_provider' => $this->serviceProvider->provider_name,
                'gop_sent' => $this->gop_sent,
                'is_cancelled' => $this->is_cancelled,
                'notes' => $this->notes
            ],
            'member' => new MemebersResource($this->whenLoaded('member')),
            'authoriser' => new UsersResource($this->whenLoaded('authoriser')),
        ];
    }
}
