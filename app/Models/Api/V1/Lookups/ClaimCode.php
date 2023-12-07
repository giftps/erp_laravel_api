<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Membership\Authorization;
use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\HealthProcessings\ProductOrServicePrice;
use App\Models\Api\V1\HealthProcessings\Tariff;

class ClaimCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'is_hospital',
        'age',
        'gender',
        'needs_preauth',
        'prescribed_amount',
        'status'
    ];

    public function benefit(){
        return $this->belongsTo(BenefitOption::class, 'benefit_option_id');
    }

    public function authorizations(){
        return $this->hasMany(Authorization::class, 'claim_code_id');
    }

    public function providerTariffs(){
        return $this->hasMany(ProductOrServicePrice::class, 'claim_code_id');
    }

    public function preauthorisations(){
        return $this->hasMany(Preauthorisation::class, 'claim_code_id');
    }

    public function tariffs(){
        return $this->hasMany(Tariff::class, 'claim_code_id');
    }
}
