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
        Schema::create('broker_houses', function (Blueprint $table) {
            $table->bigIncrements('broker_house_id');
            $table->foreignId('broker_type_id')->constrained('broker_types')->references('broker_type_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->references('user_id')->onDelete('set null')->cascadeOnUpdate();
            $table->string('name');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('code');
            $table->string('contact_person_name');
            $table->string('contact_person_email');
            $table->string('office_number')->nullable();
            $table->string('mobile_number');
            $table->text('website_address');
            $table->string('active_date')->nullable();
            $table->string('inactive_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('broker_houses');
    }
};
