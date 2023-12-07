<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeBenefitAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'scheme_option_id',
        'benefit_option_id',
        'currency_id',
        'prescribed_amount'
    ];

    public function yearOption(){
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function benefit(){
        return $this->belongsTo(BenefitOption::class, 'benefit_option_id');
    }

    public function scheme(){
        return $this->belongsTo(SchemeOption::class, 'scheme_option_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
