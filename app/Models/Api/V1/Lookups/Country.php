<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_code',
        'currency_code',
        'population',
        'capital',
        'continent'
    ];

    public function cities(){
        return $this->hasMany(City::class, 'country_id', 'id');
    }

    public function provinces(){
        return $this->hasMany(Province::class, 'country_id', 'id');
    }
}
