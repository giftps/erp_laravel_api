<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ClaimCodesResource;

use App\Models\Api\V1\Lookups\ClaimCode;

class ClaimCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $claim_codes = ClaimCode::all();

        return response()->json(ClaimCodesResource::collection($claim_codes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'benefit_option_id' => 'nullable|sometimes|integer',
            'description' => 'required|string',
        ]);

        $claim_code = new ClaimCode;
        $claim_code->benefit_option_id = $request->benefit_option_id;
        $claim_code->code = $this->generateClaimCode('store', null);
        $claim_code->description = $request->description;
        $claim_code->save();

        return response()->json(['msg' => 'saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $claim_codes = ClaimCode::with(['benefit'])->find($id);

        return response()->json(new ClaimCodesResource($claim_codes));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'benefit_option_id' => 'nullable|sometimes|integer',
            'description' => 'required|string',
        ]);

        $claim_code = ClaimCode::find($id);
        $claim_code->benefit_option_id = $request->benefit_option_id;
        $claim_code->code = $this->generateClaimCode('update', $id);
        $claim_code->description = $request->description;
        $claim_code->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ClaimCode::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }

    private function generateClaimCode($method, $id){
        $claim_code = null;
        $nextId = null;

        if ($method === 'store'){
            $claim_code = ClaimCode::all()->last();
            $nextId = ($claim_code === null ? 0 : $claim_code->id) + 1;
        }else if($method === 'update'){
            $claim_code = ClaimCode::find($id);
            $nextId = $claim_code->id;
        }

        $suffix = str_pad($nextId, 1, '0', STR_PAD_LEFT);

        $generated_claim_code = '0' . $suffix;

        return $generated_claim_code;
    }
}
