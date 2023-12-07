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
        Schema::table('case_numbers', function (Blueprint $table) {
            $table->foreignId('service_provider_id')->after('member_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_numbers', function (Blueprint $table) {
            $table->dropForeign(['service_provider_id']);
            $table->dropColumn('service_provider_id');
        });
    }
};
