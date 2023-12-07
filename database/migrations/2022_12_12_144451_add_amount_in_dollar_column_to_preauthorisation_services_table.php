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
            $table->double('amount_in_dollar')->nullable()->after('amount');
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
            $table->dropColumn('amount_in_dollar');
        });
    }
};
