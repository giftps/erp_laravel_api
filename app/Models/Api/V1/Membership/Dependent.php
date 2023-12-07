<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'first_name',
        'other_name',
        'surname',
        'notes',
        'relation',
        'blood_relative',
        'cellphone_number',
        'email',
        'gender',
        'dob',
        'id_number',
        'type',
        'benefit_start_date',
        'benefit_end_date',
        'esprit_start_date',
        'esprit_end_date',
        'monthly_fee',
        'monthly_savings'
    ];

    protected $primaryKey = 'dependent_id';

    public function mainMember(){
        return $this->belongsTo(MainMember::class, 'main_member_id');
    }

    public function medicalHistory(){
        return $this->hasMany(MedicalHistory::class, 'dependent_id');
    }

    public function familyMemberDoctor(){
        return $this->hasOne(FamilyMemberDoctor::class, 'dependent_id');
    }
}
