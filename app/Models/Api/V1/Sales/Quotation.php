<?php

namespace App\Models\Api\V1\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Membership\Family;

class Quotation extends Model
{
    use HasFactory;

    public function family(){
        return $this->belongsTo(Family::class, 'family_id');
    }
}
