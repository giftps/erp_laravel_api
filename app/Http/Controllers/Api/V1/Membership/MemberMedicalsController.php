<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\Dependent;

use App\Models\Api\V1\Membership\MedicalHistory;

use App\Http\Resources\Api\V1\Membership\MedicalHistoriesResource;

use App\Http\Requests\Api\V1\Membership\MemberMedicalsRequest;

class MemberMedicalsController extends Controller
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

            $documents = MedicalHistory::where('member_id', '=', $member_id)->get();

            return response()->json(MedicalHistoriesResource::collection($documents));
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
    public function store(MemberMedicalsRequest $request)
    {

        for($i = 0; $i < count($request->medical_history); $i++){
            $medical_history = new MedicalHistory;
            $medical_history->member_id = $request->member_id;
            $medical_history->medical_history_option_id = $request->medical_history[$i]['medical_history_option_id'];
            $medical_history->condition = $request->medical_history[$i]['condition'];
            $medical_history->doctors_name = $request->medical_history[$i]['doctors_name'];
            $medical_history->doctors_email = $request->medical_history[$i]['doctors_email'];
            $medical_history->doctors_phone_number = $request->medical_history[$i]['doctors_phone_number'];
            $medical_history->notes =  isset($request->medical_history[$i]['notes']) ? $request->medical_history[$i]['notes'] : null;
            $medical_history->save();
        }

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
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
            'member_id' => 'required|integer',
            'medical_history_option_id' => 'required|integer',
            'condition' => 'required|string',
            'notes' => 'nullable|sometimes|string'
        ]);

        $medical_history = MedicalHistory::find($id);
        $medical_history->medical_history_option_id = $request->medical_history_option_id;
        $medical_history->condition = $request->condition;
        $medical_history->doctors_name = $request->doctors_name;
        $medical_history->doctors_email = $request->doctors_email;
        $medical_history->doctors_phone_number = $request->doctors_phone_number;
        $medical_history->notes =  isset($request->notes) ? $request->notes : null;
        $medical_history->save();

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
        MedicalHistory::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
