<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Preauthorisations\PreauthorisationService;

class ServiceProviderPriceList extends Model
{
    use HasFactory;

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function tariff(){
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }

    public function preauthorisationServices(){
        return $this->hasMany(PreauthorisationService::class, 'service_price_id');
    }
}
