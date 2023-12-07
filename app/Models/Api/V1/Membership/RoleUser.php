<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public $timestamps = false;
}
