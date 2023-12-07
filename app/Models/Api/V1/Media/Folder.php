<?php

namespace App\Models\Api\V1\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    public function files(){
        return $this->hasMany(File::class, 'folder_id');
    }
}
