<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerGroupContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_group_id',
        'name',
        'phone_number',
        'email'
    ];

    protected $primaryKey = 'contact_id';

    public function employerGroup(){
        return $this->belongsTo(EmployerGroup::class);
    }
}
