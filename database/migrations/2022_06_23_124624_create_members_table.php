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
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('member_id');
            $table->foreignId('family_id')->constrained('families')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('scheme_option_id')->nullable()->constrained('scheme_options')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('scheme_type_id')->nullable()->constrained('scheme_types')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->string('dependent_code');
            $table->string('member_number');
            $table->string('title')->nullable();
            $table->string('initials')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_names')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('marital_status')->nullable();
            $table->string('language')->nullable();
            $table->string('nrc_or_passport_no')->nullable();
            $table->string('occupation')->nullable();
            $table->string('relationship')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('work_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->date('join_date')->nullable();
            $table->boolean('is_principal')->default(false);
            $table->boolean('has_sports_loading')->default(false);
            $table->date('sports_loading_start_date')->nullable();
            $table->date('sports_loading_end_date')->nullable();
            $table->string('sporting_activity')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('chronic')->nullable();
            $table->string('sage_account')->nullable();
            $table->boolean('is_chronic')->default(false);
            $table->string('login_otp')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
