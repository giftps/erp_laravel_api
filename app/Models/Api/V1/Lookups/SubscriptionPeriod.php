<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Lookups\SchemeSubscription;
use App\Models\Api\V1\Membership\Family;

class SubscriptionPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schemeSubscriptions(){
        return $this->hasMany(SchemeSubscription::class, 'subscription_period_id');
    }

    public function families(){
        return $this->hasMany(Family::class, 'subscription_period_id');
    }
}
