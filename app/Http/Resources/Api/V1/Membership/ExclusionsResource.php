<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

class ExclusionsResource extends JsonResource
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
            'id' => $this->exclusion_id,
            'family_id' => $this->member->family_id,
            'attributes' => [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'diagnosis' => $this->diagnosis,
                'notes' => $this->notes,
                'status' => $this->status,
                'show_lift_btn' => $this->end_date == date('Y-m-d') && $this->status == 'active' ? true : false,
                'excluded_by' => $this->excluder->first_name . ' ' . $this->excluder->last_name,
                'is_underwritten' => $this->member->family->is_underwritten
            ]
        ];
    }
}
