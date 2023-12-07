<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Lookups\ClaimCode;

class Tariff extends Model
{
    use HasFactory;

    public function discipline(){
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    public function claimCode(){
        return $this->belongsTo(ClaimCode::class, 'claim_code_id');
    }

    public function priceList(){
        return $this->hasMany(ServiceProviderPriceList::class, 'tariff_id');
    }
}
