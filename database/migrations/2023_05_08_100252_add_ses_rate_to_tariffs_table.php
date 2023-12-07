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
        Schema::table('tariffs', function (Blueprint $table) {
            $table->double('ses_rate')->nullable()->after('description');
            $table->string('tariff_group')->after('description');
            $table->string('effective_date')->after('tariff_group');
            $table->integer('practice_type')->after('effective_date');
            $table->string('claim_type')->nullable()->after('practice_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropColumn('ses_rate');
            $table->dropColumn('tariff_group');
            $table->dropColumn('effective_date');
            $table->dropColumn('practice_type');
            $table->dropColumn('claim_type');
        });
    }
};
