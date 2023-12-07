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
        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('address3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
        });
    }
};
