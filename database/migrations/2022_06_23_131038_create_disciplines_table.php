<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->bigIncrements('discipline_id');
            $table->string('code');
            $table->string('description');
            $table->string('used_for');
            $table->boolean('is_hospital')->default(false);
            $table->string('status');
            $table->timestamps();
        });

        \App\Models\Api\V1\ServiceProviders\Discipline::insert([
            ['code' => '00', 'description' => 'Mediplus Admin', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '04', 'description' => 'Chiropractor', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '08', 'description' => 'Homeopath', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '10', 'description' => 'Anaesthetics', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '12', 'description' => 'Dermatology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '13', 'description' => 'Ambulance & transporting services', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '14', 'description' => 'General practitioners', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '16', 'description' => 'Gynaecology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '17', 'description' => 'Pulmonology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '18', 'description' => 'Physicians', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '19', 'description' => 'Gastroenterology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '20', 'description' => 'Neurology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '21', 'description' => 'Cardiology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '22', 'description' => 'Psychiatry', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '24', 'description' => 'Neurosurgery', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '25', 'description' => 'Nuclear medicine', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '26', 'description' => 'Ophthalmology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '28', 'description' => 'Orthopaedics', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '30', 'description' => 'Otorhinolaryngology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '31', 'description' => 'Rheumatology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '32', 'description' => 'Paediatric', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '36', 'description' => 'Plastic and reconstructive surgery', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 
            ['code' => '38', 'description' => 'Radiology', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '40', 'description' => 'Radiation and oncology/nuclear medicine', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '41', 'description' => 'Haematology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '42', 'description' => 'Surgery', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '44', 'description' => 'Thoracic surgery', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '46', 'description' => 'Urology', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '47', 'description' => 'Rehabilitation centres', 'used_for' => 'Induvidual', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '50', 'description' => 'Clinicas (Out of Hospital Services)', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '51', 'description' => 'Clinicas (In-Hospital Services)', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '52', 'description' => 'Clinical pathology', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '54', 'description' => 'General dental practitioners', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '55', 'description' => 'Mental health institutions', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '56', 'description' => 'Provincial hospitals', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '57', 'description' => 'Private & government subsidised', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '58', 'description' => 'Private hospitals', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '60', 'description' => 'Pharmacies', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '62', 'description' => 'Maxillo-facial', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '64', 'description' => 'Orthodontists', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '66', 'description' => 'Occupational Therapist', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '70', 'description' => 'Optometrists', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '71', 'description' => 'Spectacle dispensers/opticians', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '72', 'description' => 'Physiotherapists', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '75', 'description' => 'Clinical and medical technologists', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '78', 'description' => 'Blood transfusion services', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '82', 'description' => 'Speech Therapist and audiologist', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '84', 'description' => 'Dietician', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '85', 'description' => 'Biokinetics Biokinetics Biocinética', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '86', 'description' => 'Clinical Psychologist', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '87', 'description' => 'Orthotics and prosthetics', 'used_for' => 'Company', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '87', 'description' => 'Nursing services', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '90', 'description' => 'Step Down Facilities', 'used_for' => 'Company', 'is_hospital' => true, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '92', 'description' => 'Periodontists', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => '94', 'description' => 'Prostodontists', 'used_for' => 'Induvidual', 'is_hospital' => false, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disciplines');
    }
};
