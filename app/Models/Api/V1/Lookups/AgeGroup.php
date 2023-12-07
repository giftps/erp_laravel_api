<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    use HasFactory;

    public function schemeSubscriptions(){
        return $this->hasOne(SchemeSubscription::class, 'age_group_id');
    }
}
