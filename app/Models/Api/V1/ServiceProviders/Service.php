<?php

namespace App\Models\Api\V1\ServiceProviders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Membership\Exclusion;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'prescribed_amount'
    ];

    protected $primaryKey = 'service_id';

    public function exclusions(){
        return $this->hasMany(Exclusion::class, 'service_id');
    }

    public function serviceProviders(){
        return $this->belongsToMany(ServiceProvider::class, 'service_providers_services', 'service_provider_id', 'service_id');
    }
}
