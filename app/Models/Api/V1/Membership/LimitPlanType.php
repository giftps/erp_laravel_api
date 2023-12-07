<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitPlanType extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_type_id',
        'limit_id'
    ];

    public $timestamps = false; 
}
