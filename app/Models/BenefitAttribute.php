<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plan_id'
    ];

    protected $primaryKey = 'benefit_attributes_id';

    public function benefit(){
        return $this->belongsTo(Benefit::class);
    }
}
