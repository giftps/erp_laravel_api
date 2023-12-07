<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_history_option_id',
        'member_id',
        'condition',
        'doctors_name',
        'doctors_email',
        'doctors_phone_number',
        'notes',
    ];

    protected $primaryKey = 'medical_history_id';

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function medicalHistoryOption(){
        $this->belongsTo(MedicalHistoryOption::class, 'medical_history_option_id');
    }
}
