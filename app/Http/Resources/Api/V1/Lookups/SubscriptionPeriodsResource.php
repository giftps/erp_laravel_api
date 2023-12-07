<?php

namespace App\Http\Resources\Api\V1\Lookups;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Lookups\SchemeSubscriptionsResource;

class SubscriptionPeriodsResource extends JsonResource
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
                'name' => $this->name
            ],
            'scheme_subscriptions' => SchemeSubscriptionsResource::collection($this->whenLoaded('schemeSubscriptions'))
        ];
    }
}
