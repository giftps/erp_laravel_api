<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;

class AuthType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function preauthorisations(){
        return $this->hasMany(Preauthorisation::class, 'auth_type_id');
    }
}
