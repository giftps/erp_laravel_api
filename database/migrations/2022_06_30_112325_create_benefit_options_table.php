<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\BenefitOption;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefit_options', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        BenefitOption::insert([
            ['code' => '001', 'description' => 'Annual Overall Limit'],
            ['code' => '002', 'description' => 'Road Ambulance'],
            ['code' => '003', 'description' => 'Air Medical Transportation'],
            ['code' => '004', 'description' => 'Repatriation'],
            ['code' => '005', 'description' => 'Hospitalisation'],
            ['code' => '006', 'description' => 'Reconstructive Surgery'],
            ['code' => '007', 'description' => 'Travel and Accomodation'],
            ['code' => '008', 'description' => 'Doctor and Specialist Consultations and Procedures'],
            ['code' => '009', 'description' => 'Prescription Medication'],
            ['code' => '010', 'description' => 'Over the Counter Medication'],
            ['code' => '011', 'description' => 'X-Rays'],
            ['code' => '012', 'description' => 'Pathology'],
            ['code' => '013', 'description' => 'Advance Imaging'],
            ['code' => '014', 'description' => 'Kidney Failure Treatment'],
            ['code' => '015', 'description' => 'Cancer Diagnosis and Treatment'],
            ['code' => '016', 'description' => 'Organ Transplants'],
            ['code' => '017', 'description' => 'Prosthesis Internal'],
            ['code' => '018', 'description' => 'Prosthesis External'],
            ['code' => '019', 'description' => 'Psychiatric Treatment'],
            ['code' => '020', 'description' => 'Chronic Condition Management'],
            ['code' => '021', 'description' => 'Physio and Chiropractor '],
            ['code' => '022', 'description' => 'Prenatal Consultations'],
            ['code' => '023', 'description' => 'Childbirth'],
            ['code' => '024', 'description' => 'Complications During Prenatal and Childbirth'],
            ['code' => '025', 'description' => 'Newborn Hospitalization'],
            ['code' => '026', 'description' => 'Birth Defects and Congenital Abnormalities'],
            ['code' => '027', 'description' => 'Termination of Pregnancy'],
            ['code' => '028', 'description' => 'Oral Care and Dental Treatment'],
            ['code' => '029', 'description' => 'Optometry'],
            ['code' => '030', 'description' => 'Wellness'],
            ['code' => '031', 'description' => 'Child Immunization'],
            ['code' => '032', 'description' => 'Nutritionist and Dietician'],
            ['code' => '033', 'description' => 'IVF'],
            ['code' => '034', 'description' => 'SES-GP Consultations and Follow-up'],
            ['code' => '035', 'description' => 'COVID-19 Testing'],
            ['code' => '036', 'description' => 'Home Based Care'],
            ['code' => '037', 'description' => 'Palliative Care'],
            ['code' => '038', 'description' => 'Rehabilitation'],
            ['code' => '039', 'description' => 'Commercial Flight'],
            ['code' => '040', 'description' => 'Sports Loading'],
            ['code' => '041', 'description' => 'Funeral Cash Benefit']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefit_options');
    }
};
