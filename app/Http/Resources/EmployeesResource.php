<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeesResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'attributes' => [
                'employee_number' => $this->employee_number,
                'name' => $this->name,
                'surname' => $this->surname,
                'email' => $this->email
            ]
        ];
    }
}
