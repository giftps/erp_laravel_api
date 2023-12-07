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
        Schema::create('member_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('benefit_option_id')->constrained('benefit_options')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('year_id')->constrained('years')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('currency');
            $table->double('limit_amount');
            $table->double('claimed_amount')->default(0);
            $table->double('limit_used')->default(0);
            $table->double('authorised_amount')->default(0);
            $table->double('remaining_amount')->default(0);
            $table->double('paid_by_member_amount')->default(0);
            $table->string('status');
            $table->date('effective_date');
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('member_benefits');
    }
};
