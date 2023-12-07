<?php

namespace App\Models\Api\V1\Preauthorisations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\Lookups\AuthType;

use App\Models\Api\V1\Lookups\ClaimCode;

use App\Models\Api\V1\Claims\Claim;

class Preauthorisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number_id',
        'member_id',
        'service_provider_id',
        'auth_type_id',
        'appointment_date',
        'admission_date',
        'estimated_discharge_date',
        'has_quotation',
        'complaint',
        'notes',
        'total_amount',
        'quotation_url'
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function authType(){
        return $this->belongsTo(AuthType::class, 'auth_type_id');
    }

    public function claim(){
        return $this->belongsTo(ClaimCode::class, 'claim_code_id');
    }

    public function claims(){
        return $this->hasMany(Claims::class, 'preauthorisation_id');
    }

    public function caseNumber(){
        return $this->belongsTo(CaseNumber::class, 'case_number_id');
    }

    public function services(){
        return $this->hasMany(PreauthorisationService::class, 'preauthorisation_id');
    }
}
