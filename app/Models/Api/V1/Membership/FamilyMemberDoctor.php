<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMemberDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'dependent_id',
        'name',
        'mobile_number',
        'email',
        'treatment_length'
    ];

    protected $primaryKey = 'family_member_doctor_id';

    public function dependent(){
        return $this->belongsTo(FamilyMember::class, 'dependent_id');
    }
}
