<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function members(){
        return $this->hasMany(Member::class, 'group_id');
    }

    public function families(){
        return $this->hasMany(Member::class, 'group_id');
    }
}
