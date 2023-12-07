<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitOption extends Model
{
    use HasFactory;

    protected $primaryKey = 'benefit_option_id';

    protected $fillable = [
        'name',
        'status'
    ];

    public function benefits(){
        return $this->belongsToMany(Benefit::class, 'benefit_option_benefits', 'benefit_id', 'benefit_option_id');
    }
}
