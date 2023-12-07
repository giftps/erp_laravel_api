<?php

namespace App\Models\Api\V1\Preauthorisations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;

class PreauthorisationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'preauthorisation_id',
        'service_price_id',
        'amount'
    ];

    public function preauthorisation(){
        return $this->belongsTo(Preauthorisation::class, 'preauthorisation_id');
    }

    public function price(){
        return $this->belongsTo(ServiceProviderPriceList::class, 'service_price_id');
    }
}
