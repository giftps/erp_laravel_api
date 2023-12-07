<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plan_id'
    ];

    protected $primaryKey = 'benefit_id';

    public function planType(){
        return $this->belongsTo(PlanType::class, 'plan_type_id');
    }

    public function benefitOptions(){
        return $this->belongsToMany(BenefitOption::class, 'benefit_option_benefits', 'benefit_option_id', 'benefit_option');
    }
}
