<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'code',
        'office_number',
        'nuit',
        'broker_id',
        'industry',
        'group_size',
        'join_date',
        'website'
    ];

    protected $primaryKey = 'employer_group_id';

    public function employerGroupContactPerson(){
        return $this->hasMany(EmployerGroupContactPerson::class);
    }

    public function members(){
        return $this->hasMany(Member::class, 'employer_group_id');
    }

    public function broker(){
        return $this->belongsTo(Broker::class, 'broker_id');
    }
}
