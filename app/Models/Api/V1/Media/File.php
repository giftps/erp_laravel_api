<?php

namespace App\Models\Api\V1\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function fileable() {
        return $this->morphTo();
    }

    public function folder(){
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}
