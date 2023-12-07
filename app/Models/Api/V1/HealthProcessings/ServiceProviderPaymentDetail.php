<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderPaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'bank',
        'account_name',
        'account_number',
        'branch_code',
        'swift_code'
    ];

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }
}
