<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\BenefitOption;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;
use App\Models\Api\V1\Lookups\Year;
use App\Http\Resources\Api\V1\Lookups\YearsResource;

class YearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = Year::all();

        return response()->json(YearsResource::collection($years));
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
            'year' => 'required|unique:years',
            'scheme_option_id' => 'nullable|sometimes|integer'
        ]);

        $year = new Year;
        $year->year = $request->year;
        $year->save();

        // Saving the scheme benefit details in the scheme benefit amounts table 
        // without adding amounts.
        if(isset($request->scheme_option_id) && $request->scheme_option_id != ''){
            $benefit_options = BenefitOption::all();
            foreach($benefit_options as $benefit){
                
            }
        }

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $years = Year::find($id);

        return response()->json(new YearsResource($years));
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
            'year' => 'required|integer|unique:years'
        ]);

        $year = Year::find($id);
        $year->year = $request->year;
        $year->save();

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
        Year::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
