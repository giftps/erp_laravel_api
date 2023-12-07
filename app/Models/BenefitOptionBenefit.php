<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitOptionBenefit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'benefit_id',
        'benefit_option_id'
    ];
}
