<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\BenefitOptionsResource;

use App\Models\Api\V1\Lookups\BenefitOption;

class BenefitOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefit_options = BenefitOption::all();

        return response()->json(BenefitOptionsResource::collection($benefit_options));
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
            'description' => 'required|string'
        ]);

        $benefit_option = new BenefitOption;
        $benefit_option->code = $this->generateBenefitCode('store', null);
        $benefit_option->description = $request->description;
        $benefit_option->save();

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
        $benefit_option = BenefitOption::find($id);

        return response()->json(new BenefitOptionsResource($benefit_option));
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
            'description' => 'required|string'
        ]);
        
        $benefit_option = BenefitOption::find($id);
        $benefit_option->code = $this->generateBenefitCode('update', $id);
        $benefit_option->description = $request->description;
        $benefit_option->save();

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
        BenefitOption::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }

    private function generateBenefitCode($method, $id){
        $benefit_option = null;
        $nextId = null;

        if ($method === 'store'){
            $benefit_option = BenefitOption::all()->last();
            $nextId = ($benefit_option === null ? 0 : $benefit_option->id) + 1;
        }else if($method === 'update'){
            $benefit_option = BenefitOption::find($id);
            $nextId = $benefit_option->id;
        }

        $suffix = str_pad($nextId, 1, '0', STR_PAD_LEFT);

        $benefit_code = '0' . $suffix;

        return $benefit_code;
    }
}
