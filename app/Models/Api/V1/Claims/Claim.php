<?php

namespace App\Models\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_number',
        'preauthorisation_id',
        'claims_logs_id',
        'member_id',
        'auth_number',
        'invoice_number'
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function preauthorisation(){
        return $this->belongsTo(Preauthorisation::class, 'preauthorisation_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function claimsLog(){
        return $this->belongsTo(ClaimsLog::class, 'claims_logs_id');
    }

    public function claimLineItems(){
        return $this->hasMany(ClaimLineItem::class, 'claim_id');
    }
}
