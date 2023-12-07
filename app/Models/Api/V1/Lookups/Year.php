<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    public function benefitsPrices(){
        return $this->hasMany(BenefitOption::class, 'year_id');
    }

    public function schemesPrices(){
        return $this->hasMany(BenefitOption::class, 'year_id');
    }
}
