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
        Schema::create('member_bank_details', function (Blueprint $table) {
            $table->bigIncrements('member_bank_details_id');
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('account_holder');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('branch');
            $table->string('branch_code');
            $table->string('account_type');
            $table->string('swift_code');
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
        Schema::dropIfExists('member_bank_details');
    }
};
