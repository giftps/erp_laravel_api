<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Sales\Broker;

use App\Models\Api\V1\Lookups\GroupType;

use App\Models\Api\V1\Lookups\SubscriptionPeriod;

use App\Models\Api\V1\Sales\Quotation;

use App\Models\Api\V1\Financials\PremiumPayment;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'broker_id',
        'membership_type_id',
        'subscription_period_id',
        'family_code',
        'physical_address',
        'postal_address',
        'postal_code',
        'in_holding_tank',
        'status',
        'application_date',
        'benefit_start_date',
        'benefit_end_date',
        'suspension_date',
        'suspension_lifted_date',
        'limit_start_date',
        'limit_end_date',
        'next_renewal_date',
        'has_funeral_cash_benefit',
        'funeral_benefit_start_date',
        'funeral_benefit_end_date',
        'beneficiary_name',
        'beneficiary_mobile_number',
        'beneficiary2_name',
        'beneficiary2_mobile_number',
        'has_sports_loading',
        'sports_loading_start_date',
        'sports_loading_end_date',
        'sporting_activity',
    ];

    public function broker(){
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    public function members(){
        return $this->hasMany(Member::class, 'family_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function groupType(){
        return $this->belongsTo(GroupType::class, 'group_type_id');
    }

    public function familySchemeDetails(){
        return $this->hasOne(FamilySchemeDetail::class, 'family_id');
    }

    public function subscriptionPeriod(){
        return $this->belongsTo(SubscriptionPeriod::class, 'subscription_period_id');
    }

    public function payments(){
        return $this->hasMany(PremiumPayment::class, 'family_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class, 'family_id');
    }
}
