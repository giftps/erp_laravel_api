<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Membership\MemberBenefit;

class BenefitOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];

    protected $hidden = ['pivot'];

    public function schemeOptions(){
        return $this->belongsToMany(SchemeOption::class, 'scheme_option_benefit_options', 'benefit_option_id', 'scheme_option_id');
    }

    public function claimCodes(){
        return $this->hasMany(ClaimCode::class, 'benefit_option_id');
    }

    public function amounts(){
        return $this->hasOne(SchemeBenefitAmount::class, 'benefit_option_id');
    }

    public function memberBenefits(){
        return $this->hasMany(MemberBenefit::class, 'benefit_option_id');
    }
}
