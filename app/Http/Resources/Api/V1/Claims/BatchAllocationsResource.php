<?php

namespace App\Http\Resources\Api\V1\Claims;

use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

class BatchAllocationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $due_date = Carbon::parse($this->claimsLog?->due_date);
        $current_date = Carbon::now();

        return [
            "id" => $this->id,
            "attributes" => [
                "batch_number" => $this->claimsLog?->batch_number,
                "assessor" => $this->assessor?->first_name . ' ' . $this->assessor?->last_name,
                "assigned_on" => $this->assigned_on,
                "due_date" => $this->claimsLog?->due_date,
                "days_remaining" => $current_date->diffInDays($due_date),
                "status" => $this->status
            ]
        ];
    }
}
