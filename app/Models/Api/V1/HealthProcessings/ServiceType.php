<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_type_id';

    public function providerTariffs(){
        return $this->hasMany(ProductOrServicePrice::class, 'service_type_id');
    }
}
