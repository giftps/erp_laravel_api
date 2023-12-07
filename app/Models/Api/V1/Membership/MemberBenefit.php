<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Lookups\BenefitOption;

class MemberBenefit extends Model
{
    use HasFactory;

    public function benefit(){
        return $this->belongsTo(BenefitOption::class, 'benefit_option_id');
    }

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }
}
