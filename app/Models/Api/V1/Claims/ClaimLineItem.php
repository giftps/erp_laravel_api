<?php

namespace App\Models\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimLineItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tariff_code',
        'claim_code',
        'diagnosis',
        'icd10',
        'currency',
        'amount',
        'date_of_service'
    ];

    public function claim(){
        return $this->belongsTo(Claim::class, 'claim_id');
    }
}
