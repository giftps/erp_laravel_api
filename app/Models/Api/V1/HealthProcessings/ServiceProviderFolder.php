<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderFolder extends Model
{
    use HasFactory;

    public function documents(){
        return $this->hasMany(ServiceProviderDocument::class, 'folder_id');
    }
}
