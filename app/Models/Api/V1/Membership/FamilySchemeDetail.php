<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilySchemeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'subscription_period_id',
        'benefit_start_date',
        'benefit_end_date',
        'has_funeral_cash_benefit',
        'funeral_benefit_start_date',
        'funeral_benefit_end_date',
        'beneficiary_name',
        'beneficiary_mobile_number',
        'beneficiary2_name',
        'beneficiary2_mobile_number'
    ];

    public function family(){
        return $this->belongsTo(Family::class, 'family_id');
    }
}
