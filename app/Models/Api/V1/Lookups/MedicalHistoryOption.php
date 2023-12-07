<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistoryOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    protected $primaryKey = 'medical_history_option_id';

    protected function medicalHistory(){
        return $this->hasMany(MedicalHistory::class, 'medical_history_id');
    }
}
