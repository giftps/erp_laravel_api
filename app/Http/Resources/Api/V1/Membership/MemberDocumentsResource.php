<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberDocumentsResource extends JsonResource
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
                'path' => url()->to('') . $this->path
            ],
            'member' => new MembersResource($this->whenLoaded('member'))
        ];
    }
}
