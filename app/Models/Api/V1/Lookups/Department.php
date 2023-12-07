<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Department extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class, 'department_id');
    }
}
