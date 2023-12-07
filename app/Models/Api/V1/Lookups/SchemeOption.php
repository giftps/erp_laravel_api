<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\MainMember;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Lookups\SchemeSubscription;

class SchemeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $hidden = ['pivot'];

    public function benefitOptions(){
        return $this->belongsToMany(BenefitOption::class, 'scheme_option_benefit_options', 'scheme_option_id', 'benefit_option_id');
    }

    public function mainMembers(){
        return $this->hasMany(MainMember::class, 'scheme_option_id');
    }

    public function subscriptions(){
        return $this->hasMany(SchemeSubscription::class, 'scheme_option_id');
    }

    public function members(){
        return $this->hasMany(Member::class, 'scheme_option_id');
    }
}
