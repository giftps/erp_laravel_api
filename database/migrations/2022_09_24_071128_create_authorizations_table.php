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
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('authorizer_id')->nullable()->constrained('users')->references('user_id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('claim_code_id')->constrained('claim_codes')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('auth_code');
            $table->boolean('gop_sent')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('authorizations');
    }
};
