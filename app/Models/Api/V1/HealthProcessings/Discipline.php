<?php

namespace App\Models\Api\V1\HealthProcessings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $primaryKey = 'discipline_id';

    public function serviceProviders(){
        return $this->hasMany(ServiceProvider::class, 'discipline_id');
    }

    public function tariffs(){
        return $this->hasMany(Tariff::class, 'discipline_id');
    }
}
