<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberBankDetailsResource extends JsonResource
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
            'member_bank_details_id' => $this->member_bank_details_id,
            'attributes' => [
                'account_holder' => $this->account_holder,
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'branch' => $this->branch,
                'branch_code' => $this->branch_code,
                'account_type' => $this->account_type,
                'swift_code' => $this->swift_code
            ],
            'member' => new MembersResource($this->whenLoaded('member'))
        ];
    }
}
