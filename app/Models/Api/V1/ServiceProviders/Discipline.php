<?php

namespace App\Models\Api\V1\ServiceProviders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'used_for',
        'is_hospital',
        'status'
    ];

    protected $primaryKey = 'discipline_id';

    public function serviceProviders(){
        return $this->hasMany(ServiceProvider::class, 'discipline_id');
    }

    public function serviceCodes(){
        return $this->belongsToMany(ServiceCode::class, 'discipline_service_codes', 'discipline_id', 'service_code_id');
    }
}
