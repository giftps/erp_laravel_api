<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

class MedicalHistoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $medical_option = MedicalHistoryOption::find($this->medical_history_option_id);

        return [
            'medical_history_id' => $this->medical_history_id,
            'attributes' => [
                'condition' => $this->condition,
                'medical_history_option_id' => $this->medical_history_option_id,
                'description' => $medical_option ? $medical_option->description : '',
                'doctors_name' => $this->doctors_name,
                'doctors_email' => $this->doctors_email,
                'doctors_phone_number' => $this->doctors_phone_number,
                'notes' => $this->notes
            ]
        ];
    }
}
