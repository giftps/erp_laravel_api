<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\Lookups\Currency;
use App\Models\Api\V1\Claims\Claim;
use App\Models\Api\V1\Claims\ClaimsLog;
use App\Models\Api\V1\Media\File;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_id',
        'pay_currency_id',
        'receive_currency_id',
        'name',
        'mobile_number',
        'email',
        'address1',
        'address2',
        'address3',
        'country',
        'practice_number',
        'is_group_practice',
        'provider_category',
        'provider_type',
        'is_ses_network_provider',
        'sla',
        'payment_term_days',
        'discount',
        'tier_level',
        'activation_date',
        'end_date',
        'status'
    ];

    protected $primaryKey = 'service_provider_id';

    public function authorisations(){
        return $this->hasMany(Authorisation::class, 'authorisation_id');
    }

    public function discipline(){
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    public function documents(){
        return $this->hasMany(ServiceProviderDocument::class, 'service_provider_id');
    }

    public function preauthorisations(){
        return $this->hasMany(Preauthorisation::class, 'service_provider_id');
    }

    public function payCurrency(){
        return $this->belongsTo(Currency::class, 'pay_currency_id');
    }

    public function receiveCurrency(){
        return $this->belongsTo(Currency::class, 'receive_currency_id');
    }

    public function productOrServicePrice(){
        return $this->hasMany(ProductOrServicePrice::class, 'service_provider_id');
    }

    public function claims(){
        return $this->hasMany(Claim::class, 'service_provider_id');
    }

    public function claimsLogs(){
        return $this->hasMany(ClaimsLog::class, 'service_provider_id');
    }
    
    public function contactPerson(){
        return $this->hasMany(ServiceProviderContact::class, 'service_provider_id');
    }

    public function paymentDetails(){
        return $this->hasMany(ServiceProviderPaymentDetail::class, 'service_provider_id');
    }

    public function priceList(){
        return $this->hasMany(ServiceProviderPriceList::class, 'service_provider_id');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
