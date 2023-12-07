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
            $table->dropColumn('tariff_group');
            $table->dropColumn('practice_type');
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
            $table->string('tariff_group');
            $table->string('practice_type');
        });
    }
};
