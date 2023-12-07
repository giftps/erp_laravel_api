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
        Schema::create('claims_logs', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number');
            $table->foreignId('service_provider_id')->nullable()->constrained('service_providers')->references('service_provider_id')->onDelete('set null')->cascadeOnUpdate();
            $table->date('date_received');
            $table->date('due_date');
            $table->string('statement_month');
            $table->double('statement_total');
            $table->integer('number_of_invoices');
            $table->foreignId('receiver_id')->constrained('users')->references('user_id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('claims_logs');
    }
};
