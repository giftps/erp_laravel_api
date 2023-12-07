<?php

namespace App\Models\Api\V1\Preauthorisations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

class CaseNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'case_number'
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function preauthorisations(){
        return $this->hasMany(Preauthorisation::class, 'case_number_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }
}
