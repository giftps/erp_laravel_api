<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];

    protected $primaryKey = 'limit_id';

    protected $hidden = ['pivot'];

    public function planTypes(){
        return $this->belongsToMany(PlanType::class, 'limit_plan_types', 'limit_id', 'plan_type_id');
    }
}
