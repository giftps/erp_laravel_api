<?php

namespace App\Models\Api\V1\UserAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'role_id';

    protected $hidden = ['pivot'];

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }

    public function permission(){
        return $this->hasMany(Permission::class, 'role_id');
    }
}
