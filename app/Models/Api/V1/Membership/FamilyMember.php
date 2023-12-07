<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_member_id',
        'member_number',
        'first_name',
        'surname',
        'alias',
        'occupation',
        'id_number',
        'dob',
        'sex',
        'is_main_member',
        'has_sporting_activities',
        'sporting_activity_details',
        'weight',
        'height'
    ];

    protected $primaryKey = 'family_member_id';

    public function mainMember(){
        return $this->belongsTo(MainMember::class, 'main_member_id');
    }

    public function medicalHistory(){
        return $this->hasMany(MedicalHistory::class, 'family_member_id');
    }

    public function familyMemberDoctor(){
        return $this->hasOne(FamilyMemberDoctor::class, 'family_member_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
}
