<?php

namespace App\Http\Resources\Api\V1\Membership;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Api\V1\Lookups\Year;

use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

class MemberBenefitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $year = Year::where('id', '=', $this->year_id)->first()?->year;
        $scheme_option_id = $this->member->scheme_option_id;
        $scheme_benefit_amounts = SchemeBenefitAmount::where('scheme_option_id', '=', $scheme_option_id)->where('year_id', '=', $this->year_id)->where('benefit_option_id', '=', $this->benefit_option_id)->first();

        $percentage_used = 0;

        if($this->limit_used > 0){
            $percentage_used = round(((double)$this->limit_used/(double)$this->limit_amount)*100, 2);
        }

        if($percentage_used > 100){
            $percentage_used = 100;
        }

        return [
            'id' => $this->id,
            'attributes' => [
                'description' => $this->benefit->description,
                'currency' => $this->currency,
                'limit_amount' => $this->limit_amount ?? 0,
                'claimed_amount' => $this->claimed_amount,
                'limit_used' => $this->limit_used,
                'authorised_amount' => $this->authorised_amount,
                'remaining_amount' => $this->remaining_amount,
                'paid_by_member_amount' => $this->paid_by_member_amount,
                'status' => $this->status,
                'year' => $year,
                'effective_date' => $this->effective_date,
                'end_date' => $this->effective_date,
                'percentage_used' => $this->limit_used != 0 ?  $percentage_used : 0,
            ]
        ];
    }
}
