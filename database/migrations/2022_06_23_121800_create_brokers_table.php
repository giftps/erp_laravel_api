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
        Schema::create('brokers', function (Blueprint $table) {
            $table->bigIncrements('broker_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->references('user_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('broker_house_id')->constrained('broker_houses')->references('broker_house_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code');
            $table->string('title');
            $table->string('first_name');
            $table->string('surname');
            $table->string('id_number');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('office_number');
            $table->string('phone_number');
            $table->string('email');
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
        Schema::dropIfExists('brokers');
    }
};
