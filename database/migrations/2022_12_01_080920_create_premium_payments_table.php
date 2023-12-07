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
        Schema::create('premium_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('processed_by')->nullable()->constrained('users')->references('user_id')->cascadeOnDelete()->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->references('user_id')->cascadeOnDelete()->onDelete('set null');
            $table->string('receipt_number');
            $table->string('currency');
            $table->double('tax')->nullable();
            $table->double('amount');
            $table->text('receipt_path')->nullable();
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
        Schema::dropIfExists('premium_payments');
    }
};
