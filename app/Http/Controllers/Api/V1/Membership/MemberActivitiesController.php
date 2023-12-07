<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Membership\MemberActivitiesResource;

use App\Models\Api\V1\Membership\MemberActivity;

class MemberActivitiesController extends Controller
{
    public function memberActivities($member_id){
        $member_activities = MemberActivity::where('member_id', '=', $member_id)->orderBy('created_at', 'DESC')->limit(30)->get();
        return response()->json(MemberActivitiesResource::collection($member_activities));
    }
}
