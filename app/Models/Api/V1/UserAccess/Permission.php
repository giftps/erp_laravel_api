<?php

namespace App\Models\Api\V1\UserAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'can_add',
        'can_edit',
        'can_delete'
    ];

    public function module(){
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }
}
