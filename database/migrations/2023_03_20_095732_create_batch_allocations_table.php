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
        Schema::create('batch_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claims_log_id')->constrained('claims_logs')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('assessor_id')->constrained('users')->references('user_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('assigned_on');
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
        Schema::dropIfExists('batch_allocations');
    }
};
