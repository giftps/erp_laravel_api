<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\FamilyMemberDoctor;

use App\Models\Api\V1\Membership\Dependent;

use App\Models\Api\V1\Membership\MedicalHistory;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

use App\Http\Resources\MedicalHistoryOptionsResource;

class MedicalsController extends Controller
{
    public function getAllMedicalOptions(){
        $medical_options = MedicalHistoryOption::all();

        return response()->json(MedicalHistoryOptionsResource::collection($medical_options));
    }

    public function storeMemberMedicalCondition(Request $request){

        
    }

    // Addign the doctor who knows dependent's condition
    private function addDoctor($request){
        $family_member_doctor = new FamilyMemberDoctor;
        $family_member_doctor->dependent_id = $request->dependent_id;
        $family_member_doctor->name = $request->doctor_full_name;
        $family_member_doctor->mobile_number = $request->doctor_mobile_number;
        $family_member_doctor->email = $request->doctor_email;
        $family_member_doctor->treatment_length = $request->length_of_treatment;
        $family_member_doctor->save();
    }
}
