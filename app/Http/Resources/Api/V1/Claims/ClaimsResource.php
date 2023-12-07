<?php

namespace App\Http\Resources\Api\V1\Claims;

use Illuminate\Http\Resources\Json\JsonResource;

class ClaimsResource extends JsonResource
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
                'member_id' => $this->member?->member_id,
                'member_number' => $this->member?->member_number,
                'member_name' => $this->member?->first_name . ' ' . $this->member?->last_name,
                'service_provider_id' => $this->claimsLog?->serviceProvider?->service_provider_id,
                'service_provider' => $this->claimsLog?->serviceProvider?->name,
                'auth_code' => $this->preauthorisation?->auth_code,
                'claim_number' => $this->claim_number,
                'invoice_number' => $this->invoice_number
            ],
            'line_items' => ClaimLineItemsResource::collection($this->whenLoaded('claimLineItems'))
        ];
    }
}
