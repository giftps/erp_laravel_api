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
        Schema::table('preauthorisation_services', function (Blueprint $table) {
            $table->foreignId('service_price_id')->after('preauthorisation_id')->constrained('service_provider_price_lists')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preauthorisation_services', function (Blueprint $table) {
            $table->dropForeign(['service_price_id']);
            $table->dropColumn('service_price_id');
        });
    }
};
