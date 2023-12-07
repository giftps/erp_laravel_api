<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ClaimCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benefit_option_id')->nullable()->constrained('benefit_options')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code');
            $table->string('description');
            $table->boolean('is_hospital')->default(false);
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('needs_preauth')->nullable();
            $table->double('prescribed_amount')->default(0);
            $table->string('status');
            $table->timestamps();
        });

        ClaimCode::insert([
            ['code' => '001', 'description' => 'Local Road Ambulance', 'status' => 'active'],
            ['code' => '002', 'description' => 'International Road Ambulance', 'status' => 'active'],
            ['code' => '003', 'description' => 'Local Air Ambulance', 'status' => 'active'],
            ['code' => '004', 'description' => 'International Air Ambulance', 'status' => 'active'],	
            ['code' => '005', 'description' => 'Commerical Evacuation', 'status' => 'active'],	
            ['code' => '006', 'description' => 'Repatriation to Country of Residence', 'status' => 'active'],	
            ['code' => '007', 'description' => 'Repatriation of Mortal Remains or Burial', 'status' => 'active'],	
            ['code' => '008', 'description' => 'Acute Emergency Admission', 'status' => 'active'],	
            ['code' => '009', 'description' => 'Elective/Planned Admission', 'status' => 'active'],	
            ['code' => '010', 'description' => 'Day Admission', 'status' => 'active'],	
            ['code' => '011', 'description' => 'High Care Admission', 'status' => 'active'],	
            ['code' => '012', 'description' => 'ICU Admission', 'status' => 'active'],	
            ['code' => '013', 'description' => 'Reconstructive Surgery', 'status' => 'active'],	
            ['code' => '014', 'description' => 'Travel and Accomodation', 'status' => 'active'],	
            ['code' => '015', 'description' => 'Dr and Specialist Consultations', 'status' => 'active'], 	
            ['code' => '016', 'description' => 'Diagnostic/Surgical Procedures', 'status' => 'active'],	
            ['code' => '017', 'description' => 'Prescription Medication', 'status' => 'active'],	
            ['code' => '018', 'description' => 'Chronic Medication', 'status' => 'active'],	
            ['code' => '019', 'description' => 'Over the Counter Medication', 'status' => 'active'],	
            ['code' => '020', 'description' => 'X-Rays', 'status' => 'active'],	
            ['code' => '021', 'description' => 'CT Scan', 'status' => 'active'],	
            ['code' => '022', 'description' => 'MRI Scan', 'status' => 'active'],	
            ['code' => '023', 'description' => 'PET Scan', 'status' => 'active'],	
            ['code' => '024', 'description' => 'Ultrasound Scan', 'status' => 'active'],	
            ['code' => '025', 'description' => 'Pathology', 'status' => 'active'],	
            ['code' => '026', 'description' => 'Kidney Dialysis', 'status' => 'active'], 	
            ['code' => '027', 'description' => 'Cancer Diagnosis and Treatment', 'status' => 'active'],	
            ['code' => '028', 'description' => 'Prosthesis Internal', 'status' => 'active'],	
            ['code' => '028', 'description' => 'Prosthesis External', 'status' => 'active'],	
            ['code' => '029', 'description' => 'Psychiatric Treatment', 'status' => 'active'],	
            ['code' => '030', 'description' => 'Chronic Condition Management', 'status' => 'active'],	
            ['code' => '031', 'description' => 'Physiotheraphy', 'status' => 'active'],	
            ['code' => '032', 'description' => 'Chirotherpahy', 'status' => 'active'],	
            ['code' => '033', 'description' => 'Prenatal & Postnatal Consultations', 'status' => 'active'],	
            ['code' => '034', 'description' => 'Childbirth', 'status' => 'active'],	
            ['code' => '035', 'description' => 'Complications During Pernatal and Childbirth', 'status' => 'active'],	
            ['code' => '036', 'description' => 'Newborn Hospitalization', 'status' => 'active'],	
            ['code' => '037', 'description' => 'Birth Defects and Congenital Abnormalities', 'status' => 'active'],	
            ['code' => '038', 'description' => 'Termination of Pregnancy', 'status' => 'active'],	
            ['code' => '039', 'description' => 'Oral Care and Dental Treatment', 'status' => 'active'],	
            ['code' => '040', 'description' => 'Optical Consultations', 'status' => 'active'],	
            ['code' => '041', 'description' => 'Optical Frames', 'status' => 'active'],	
            ['code' => '042', 'description' => 'Optical Lenses', 'status' => 'active'],	
            ['code' => '043', 'description' => 'Wellness', 'status' => 'active'],	
            ['code' => '044', 'description' => 'Child Immunization', 'status' => 'active'],	
            ['code' => '045', 'description' => 'Nutritionist and Dietician', 'status' => 'active'],	
            ['code' => '046', 'description' => 'IVF', 'status' => 'active'],	
            ['code' => '047', 'description' => 'Organ Stransplants', 'status' => 'active'],	
            ['code' => '048', 'description' => 'SES-GP Consultations and Follow-up', 'status' => 'active'],	
            ['code' => '049', 'description' => 'COVID-19 Testing', 'status' => 'active'],	
            ['code' => '050', 'description' => 'Home Based Care', 'status' => 'active'],	
            ['code' => '051', 'description' => 'Palliative Care', 'status' => 'active'],	
            ['code' => '052', 'description' => 'Rehabilitation', 'status' => 'active'],	
            ['code' => '053', 'description' => 'Economy Flight', 'status' => 'active'],	
            ['code' => '054', 'description' => 'Sports Loading', 'status' => 'active'],	
            ['code' => '055', 'description' => 'Funeral Cash Benefit', 'status' => 'active'],	
            ['code' => '099', 'description' => 'Zero Benefit', 'status' => 'active']	
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_codes');
    }
};
