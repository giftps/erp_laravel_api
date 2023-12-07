<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderDocument extends Model
{
    use HasFactory;

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function folder(){
        return $this->belongsTo(ServiceProviderFolder::class, 'folder_id');
    }
}
