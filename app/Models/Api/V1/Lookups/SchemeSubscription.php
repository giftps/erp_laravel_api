<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\Currency;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;

class SchemeSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'scheme_option_id',
        'subscription_name',
        'amount',
        'tax_percentage'
    ];

    public function yearOption(){
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function scheme(){
        return $this->belongsTo(SchemeOption::class, 'scheme_option_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function subscriptionPeriod(){
        return $this->belongsTo(SubscriptionPeriod::class, 'subscription_period_id');
    }

    public function ageGroup(){
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }
}
