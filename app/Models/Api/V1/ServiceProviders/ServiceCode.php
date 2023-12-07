<?php

namespace App\Models\Api\V1\ServiceProviders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Exclusion;

class ServiceCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'is_hospital',
        'age',
        'gender',
        'prescribed_amount',
        'status'
    ];

    protected $primaryKey = 'service_code_id';

    public function disciplines(){
        return $this->belongsToMany(Discipline::class, 'discipline_service_codes', 'service_code_id', 'discipline_id');
    }

    public function exclusions(){
        return $this->hasMany(Exclusion::class, 'service_code_id');
    }
}
