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
        Schema::create('exclusions', function (Blueprint $table) {
            $table->bigIncrements('exclusion_id');
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->string('status');
            $table->foreignId('excluded_by')->constrained('users')->references('user_id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('exclusions');
    }
};
