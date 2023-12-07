<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Lookups\ClaimCode;
use App\Models\Api\V1\Preauthorisations\PreauthorisationService;

class ProductOrServicePrice extends Model
{
    use HasFactory;

    public function claimCode(){
        return $this->belongsTo(ClaimCode::class, 'claim_code_id');
    }

    public function serviceType(){
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function services(){
        return $this->hasMany(PreauthorisationService::class, 'service_price_id');
    }
}
