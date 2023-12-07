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
        Schema::table('families', function (Blueprint $table) {
            $table->string('beneficiary2_name')->nullable()->after('beneficiary_mobile_number');
            $table->string('beneficiary2_mobile_number')->nullable()->after('beneficiary2_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('beneficiary2_name');
            $table->dropColumn('beneficiary2_mobile_number');
        });
    }
};
