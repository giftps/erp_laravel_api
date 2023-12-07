<?php

namespace App\Http\Resources\Api\V1\Claims;

use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

class ClaimsLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $due_date = Carbon::parse($this->due_date);
        $current_date = Carbon::now();

        return [
            'id' => $this->id,
            'attributes' => [
                "batch_number" => $this->batch_number,
                "date_received" => $this->date_received,
                "received_by" => $this->receivedBy?->first_name . ' ' . $this->receivedBy?->last_name,
                "service_provider" => $this->serviceProvider?->name,
                "service_provider_id" => $this->service_provider_id,
                "due_date" => $this->due_date,
                "days_remaining" => $current_date->diffInDays($due_date),
                "statement_month" => $this->statement_month,
                "statement_total" => $this->statement_total,
                "number_of_invoices" => $this->number_of_invoices,
                "receiver_id" => $this->receiver_id,
                "status" => $this->status
            ]
        ];
    }
}
