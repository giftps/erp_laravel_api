<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'tier_id',
        'tier_name'
    ];

    public $primaryKey = 'tier_id';

    public function plans(){
        return $this->hasMany(Plan::class, 'tier_id');
    }
}
