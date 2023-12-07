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
        Schema::create('preauthorisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('auth_type_id')->nullable()->constrained('auth_types')->references('id')->cascadeOnUpdate()->onDelete('set null');
            $table->string('auth_code');
            $table->date('appointment_date')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('estimated_discharge_date')->nullable();
            $table->string('complaint')->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->double('total_amount')->nullable();
            $table->text('quotation_url')->nullable();
            $table->boolean('gop_sent')->default(false);
            $table->string('status')->default('active');
            $table->date('cancellation_date')->nullable();
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
        Schema::dropIfExists('preauthorisations');
    }
};
