<?php

namespace App\Http\Resources\Api\V1\Preauthorisations;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Api\V1\Membership\MembersResource;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProvidersResource;

class PreauthorisationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $member = $this->whenLoaded('member');
        $service_provider = $this->whenLoaded('serviceProvider');

        return [
            'id' => $this->id,
            'attributes' => [
                'member_number' => $this->member->member_number,
                'member_id' => $this->member->member_id,
                'auth_code' => $this->auth_code,
                'case_number' => $this->caseNumber?->case_number,
                'first_name' => $this->member->first_name,
                'last_name' => $this->member->last_name,
                'service_provider' => $this->serviceProvider->provider_name,
                'auth_type' => $this->authType->description,
                'appointment_date' => $this->appointment_date,
                'admission_date' => $this->admission_date,
                'estimated_discharge_date' => $this->estimated_discharge_date,
                'has_quotation' => $this->has_quotation,
                'complaint' => $this->complaint,
                'diagnosis' => $this->diagnosis,
                'notes' => $this->notes,
                'status' => $this->status,
                'gop_sent' => $this->gop_sent,
                'currency' => $this->serviceProvider->receiveCurrency->code,
                'total_amount' => $this->total_amount,
                'total_amount_in_dollar' => $this->amount_in_dollar,
                'ses_pay_amout' => $this->ses_pay_amount,
                'member_pay_amount' => $this->member_pay_amount,
                'quotation_url' => $this->quotation_url,
                'auth_date' => explode(" ", $this->created_at)[0] . ' ' . explode(" ", $this->created_at)[1]
            ],
            'services' => PreauthorisationServicesResource::collection($this->whenLoaded('services')),
            'member' => new MembersResource($member),
            'service_provider' => new ServiceProvidersResource($this->serviceProvider)
        ];
    }
}
