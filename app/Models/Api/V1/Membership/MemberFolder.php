<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberFolder extends Model
{
    use HasFactory;

    public function memberDocuments(){
        return $this->hasMany(MemberDocument::class, 'member_folder_id');
    }
}
