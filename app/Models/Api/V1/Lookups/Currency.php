<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];

    public function schemeSubscriptions(){
        return $this->hasMany(SchemeSubscription::class, 'currency_id');
    }

    public function serviceProviderPay(){
        return $this->hasMany(ServiceProvider::class, 'pay_currency_id');
    }

    public function serviceProviderReceive(){
        return $this->hasMany(ServiceProvider::class, 'receive_currency_id');
    }

    public function benefitAmount(){
        return $this->hasOne(SchemeBenefitAmount::class, 'currency_id');
    }
}
