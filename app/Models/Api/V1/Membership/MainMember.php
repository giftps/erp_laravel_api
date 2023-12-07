<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\SchemeType;
use App\Models\Api\V1\Sales\Broker;

class MainMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheme_option_id',
        'scheme_type_id',
        'broker_id',
        'family_code',
        'member_type',
        'title',
        'first_name',
        'last_name',
        'other_names',
        'dob',
        'sex',
        'nationality',
        'nrc_or_passport_no',
        'occupation',
        'email',
        'work_number',
        'mobile_number',
        'physical_address',
        'postal_address',
        'nearest_city',
        'postal_code',
        'subscription_type',
        'in_holding_tank',
        'status',
        'application_date',
        'join_date',
        'benefit_start_date',
        'end_date',
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

    protected $primaryKey = 'main_member_id';

    public function schemeAdministrator(){
        return $this->belongsTo(SchemeAdministrator::class, 'scheme_admin_id');
    }

    public function dependents(){
        return $this->hasMany(Dependent::class, 'main_member_id');
    }

    public function schemeOption(){
        return $this->belongsTo(SchemeOption::class, 'scheme_option_id');
    }

    public function schemeType(){
        return $this->belongsTo(SchemeType::class, 'scheme_type_id');
    }

    public function broker(){
        return $this->belongsTo(Broker::class, 'broker_id');
    }
}
