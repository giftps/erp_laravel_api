<?php

namespace App\Models\Api\V1\Financials;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Family;

class PremiumPayment extends Model
{
    use HasFactory;

    public function family(){
        return $this->belongsTo(Family::class, 'family_id');
    }
}
