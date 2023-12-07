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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preauthorisation_id')->nullable()->constrained('preauthorisations')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->string('claim_number');
            $table->foreignId('claims_logs_id')->constrained('claims_logs')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('auth_number');
            $table->string('invoice_number');
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
        Schema::dropIfExists('claims');
    }
};
