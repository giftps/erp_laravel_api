<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plan_id',
        'status'
    ];

    protected $primaryKey = 'plan_type_id';

    public function benefits(){
        return $this->hasMany(Benefit::class, 'plan_type_id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function members(){
        return $this->hasMany(MainMember::class, 'plan_type_id');
    }

    public function limits(){
        return $this->belongsToMany(Limit::class, 'limit_plan_types', 'plan_type_id', 'limit_id');
    }
}
