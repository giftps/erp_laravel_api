<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use PDF;

use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Sales\Broker;

class QuotationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function renewalQuotation()
    {
        $data = [
            'imagePath'    => public_path('img/profile.png'),
            'name'         => 'John Doe',
            'address'      => 'USA',
            'mobileNumber' => '000000000',
            'email'        => 'john.doe@email.com'
        ];
        $pdf = PDF::loadView('documents.renewal-quotation', $data);

        // Saving to starage;
        // Storage::put('public/pdf/quotation.pdf', $pdf->output());

        return $pdf->stream('renewal-quotation.pdf');
    }

    public function newMemberQuotation(){
        $scheme_options = SchemeOption::where('tier_level', '=', 1)->get();
        $members = Member::where('family_id', '=', 1)->get();
        $broker = Broker::find(1);
        $quotation_number = '12323443';
        $quotation_type = 'Comparative';
        $discount = 15;

        $cover_start_date = date('d') > 10 ? date('d M, Y', strtotime("+1 months", strtotime(date('Y') . '-' . date('m') . '-01'))) : date('Y') . '-' . date('m') . '-01';
        $cover_end_date = date('d') > 10 ? date('d M, Y', strtotime("+13 months", strtotime(date('Y') . '-' . date('m') . '-01'))) : date('Y-m-d', strtotime("+12 months", strtotime(date('Y') . '-' . date('m') . '-01')));

        $data = [
            'broker' => $broker,
            'members' => $members,
            'scheme_options' => $scheme_options,
            'quotation_number' => $quotation_number,
            'quotation_type' => $quotation_type,
            'discount' => $discount,
            'subscription_period_id' => 1,
            'cover_start_date' => $cover_start_date,
            'cover_end_date' => $cover_end_date
        ];
        $pdf = PDF::loadView('documents.new-member-quotation', $data);

        // Saving to starage;
        // Storage::put('public/pdf/quotation.pdf', $pdf->output());

        return $pdf->stream('quotation.pdf');
    }
}
