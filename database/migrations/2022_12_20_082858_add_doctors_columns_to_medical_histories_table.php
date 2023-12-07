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
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->string('doctors_name')->nullable()->after('member_id');
            $table->string('doctors_email')->nullable()->after('doctors_name');
            $table->string('doctors_phone_number')->nullable()->after('doctors_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->dropColumn('doctors_name');
            $table->dropColumn('doctors_email');
            $table->dropColumn('doctors_phone_number');
        });
    }
};
