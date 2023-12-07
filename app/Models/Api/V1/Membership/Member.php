<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\SchemeType;

use App\Models\Api\V1\Media\File;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\Preauthorisations\CaseNumber;

use App\Models\Api\V1\Claims\Claim;

class Member extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'scheme_option_id',
        'scheme_type_id',
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
        'join_date'
    ];

    protected $hidden = [
        'pivot',
        'password',
    ];

    protected $primaryKey = 'member_id';

    public function family(){
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function schemeOption(){
        return $this->belongsTo(SchemeOption::class, 'scheme_option_id');
    }

    public function schemeType(){
        return $this->belongsTo(SchemeType::class, 'scheme_type_id');
    }

    public function authorizations(){
        return $this->hasMany(Authorization::class, 'member_id');
    }

    public function documents(){
        return $this->hasMany(MemberDocument::class, 'member_id');
    }

    public function medicalHistory(){
        return $this->hasMany(MedicalHistory::class, 'member_id');
    }

    public function preauthorisations(){
        return $this->hasMany(Preauthorisation::class, 'member_id');
    }

    public function memberBenefits(){
        return $this->hasMany(MemberBenefit::class, 'member_id');
    }

    public function claims(){
        return $this->hasMany(Claim::class, 'member_id');
    }

    public function caseNumbers(){
        return $this->hasMany(CaseNumber::class, 'member_id');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }

    public function findForPassport($member_number) {
        return $this->where('member_number', $member_number)->orWhere('email', '=', $member_number)->orWhere('mobile_number', '=', $member_number)->first();
    }

    public function routeNotificationForVonage($notification)
    {
        return $this->mobile_number;
    }
}
