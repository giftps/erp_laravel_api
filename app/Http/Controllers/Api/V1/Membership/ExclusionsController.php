<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Api\V1\Membership\ExclusionsRequest;

use App\Models\Api\V1\Membership\Exclusion;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;

use App\Http\Resources\Api\V1\Membership\ExclusionsResource;

use App\Notifications\Underwriting;

use App\Models\Api\V1\Membership\MemberDocument;
use Illuminate\Support\Facades\Storage;

use PDF;

class ExclusionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['member_id']) && $_GET['member_id'] !== ''){
            $member_id = $_GET['member_id'];
            $exclusions = Exclusion::where('member_id', '=', $member_id)->get();
            return response()->json(ExclusionsResource::collection($exclusions));
        }else{
            return response()->json(['msg' => 'the member id was not specified in the url', 'status' => 422], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExclusionsRequest $request)
    {
        $this->validate($request, [
            'member_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'diagnosis' => 'required|string',
        ]);

        $exclusion = new Exclusion;
        $exclusion->member_id = $request->member_id;
        $exclusion->start_date = $request->start_date;
        $exclusion->end_date = $request->end_date;
        $exclusion->diagnosis = $request->diagnosis;
        $exclusion->status = $request->status;
        $exclusion->excluded_by = auth('api')->user()->user_id;
        $exclusion->save();

        $member = Member::find($request->member_id);

        $name = auth()->user()?->first_name . ' ' . auth()->user()?->last_name;

        memberActivity($member->member_id, $name . ' added an exclusion of ' . $request->diagnosis . '.');

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExclusionsRequest $request, $id)
    {
        $this->validate($request, [
            'member_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'diagnosis' => 'required|string',
        ]);

        $exclusion = Exclusion::find($id);
        $exclusion->member_id = $request->member_id;
        $exclusion->start_date = $request->start_date;
        $exclusion->end_date = $request->end_date;
        $exclusion->diagnosis = $request->diagnosis;
        $exclusion->status = $request->status;
        $exclusion->excluded_by = auth('api')->user()->user_id;
        $exclusion->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Exclusion::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }

    // Submitting the underwritting for the family
    public function underWrite(Request $request){
        $this->validate($request, [
            'family_id' => 'required|integer',
        ]);

        $family = Family::find($request->family_id);
        $family->is_underwritten = true;
        $family->status = 'pending payment';
        $family->save();

        // Generating the registration token for the user
        $registration_token = $family->registration_token;

        if(!$family->registration_token){
            $registration_token = base64_encode($family->members()->where('dependent_code', '=', '00')->first()->email . time());

            $family->registration_token = $registration_token;
            $family->save();
        }

        $exclusions = $family->members->map(function ($member){
            $excls = Exclusion::where('member_id', '=', $member->member_id)->get();

            return collect([
                'member_id' => $member->member_id,
                'attributes' => collect([
                    'name' => $member->first_name . ' ' . $member->last_name,
                    'dob' => $member->dob
                ]),
                'exclusions' => $excls->map(function ($excl){
                    return collect([
                        'exclusion_id' => $excl->exclusion_id,
                        'attributes' => collect([
                            'diagnosis' => $excl->diagnosis,
                            'start_date' => $excl->start_date,
                            'end_date' => $excl->end_date
                        ])
                    ]);
                })
            ]);
        });

        $family->is_underwritten = true;
        $family->save();

        $member = $family->members()->where('dependent_code', '=', '00')->first();

        $attachement = $this->generateUnderwritingLetter($member, $exclusions);

        // Getting the origin url
        $origin_url = getOriginUrl();

        $member->notify(new Underwriting($member, $exclusions, $registration_token, $attachement, $origin_url));

        return response()->json(['msg' => 'saved successfully!', 'token' => $registration_token, 'status' => 200], 200);
    }

    public function liftExclusion(Request $request){
        $this->validate($request, [
            'exclusion_id' => 'required|integer'
        ]);
        $exclusion = Exclusion::find($request->exclusion_id);
        $exclusion->status ='lifted';
        $exclusion->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    public function generateUnderwritingLetter($member, $exclusions){
        $data = [
            'member' => $member,
            'exclusions' => $exclusions
        ];

        $pdf = PDF::loadView('documents.underwriting-letter', $data);

        $file = 'Underwriting' . $member->member_number . time() .'.pdf';

        $filePath = 'public/underwriting-letter/' . $file;
        $path = '/storage/underwriting-letter/' . $file;
    
        // Saving to starage;
        Storage::put($filePath, $pdf->output());
    
        // return $pdf->stream('gop.pdf');

        // Saving the membership schedule in member documents
        $member_document = new MemberDocument;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'Underwriting Letter';
        $member_document->path = $path;
        $member_document->save();

        return Storage::path($filePath);
    }
}
