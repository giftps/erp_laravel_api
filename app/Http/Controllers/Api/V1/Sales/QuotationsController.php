<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Sales\Quotation;
use App\Models\Api\V1\Membership\Member;
use App\Http\Resources\Api\V1\Sales\QuotationsResource;

class QuotationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function familyQuotations($family_id)
    {
        $quots = Quotation::where('family_id', '=', $family_id);

        if(isset($_GET['member_number']) && $_GET['member_number'] != ''){
            $member_number = $_GET['member_number'];

            $family_id = Member::where('member_number', '=', $member_number)->first()?->family?->id;

            $quots->where('family_id', '=', $family_id);
        }

        if(isset($_GET['mobile_number']) && $_GET['mobile_number'] != ''){
            $mobile_number = $_GET['mobile_number'];
            
            $family_id = Member::where('mobile_number', 'LIKE', '%' . $mobile_number .'%')->first()?->family?->id;
            
            $quots->where('family_id', '=', $family_id);
        }

        $quotations = $quots->orderBy('created_at', 'DESC')->get();

        return response()->json(QuotationsResource::collection($quotations));
    }
}
