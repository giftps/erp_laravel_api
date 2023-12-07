<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tier_id'
    ];

    public $primaryKey = 'plan_id';

    public function tier(){
        return $this->belongsTo(PlanTier::class, 'tier_id');
    }

    public function planTypes(){
        return $this->hasMany(PlanType::class, 'plan_id');
    }
}
