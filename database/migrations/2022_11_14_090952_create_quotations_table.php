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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('quotation_number');
            $table->text('path');
            $table->string('status')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->boolean('is_first')->default(false);
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
        Schema::dropIfExists('quotations');
    }
};
