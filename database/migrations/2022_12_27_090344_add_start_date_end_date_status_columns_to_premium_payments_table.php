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
        Schema::table('premium_payments', function (Blueprint $table) {
            $table->date('start_date')->after('receipt_path')->default(date('Y-m-d'));
            $table->date('end_date')->after('start_date')->default(date('Y-m-d'));
            $table->string('status')->after('end_date')->default('completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('premium_payments', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }
};
