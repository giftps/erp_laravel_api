<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_new_application',
        'is_individual_account',
        'account_name',
        'first_name',
        'surname',
        'dob',
        'nationality',
        'sex',
        'postal_address',
        'postal_code',
        'telephone_number',
        'mobile_number',
        'email1',
        'email2',
        'id_type',
        'id_number',
        'tpin'
    ];

    protected $primaryKey = 'scheme_admin_id';

    public function mainMembers(){
        $this->hasMany(MainMember::class, 'main_member_id');
    }
}
