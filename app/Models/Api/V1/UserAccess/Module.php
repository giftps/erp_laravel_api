<?php

namespace App\Models\Api\V1\UserAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path'
    ];

    protected $primaryKey = 'module_id';

    protected $hidden = ['pivot'];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_modules', 'module_id', 'role_id');
    }

    public function permission(){
        return $this->hasOne(Permission::class, 'module_id');
    }
}
