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
        Schema::table('claim_line_items', function (Blueprint $table) {
            $table->double('assessed_amount')->after('amount')->nullable();
            $table->double('rejected_amount')->after('assessed_amount')->nullable();
            $table->string('comment')->after('rejected_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claim_line_items', function (Blueprint $table) {
            $table->dropColumn('assessed_amount');
            $table->dropColumn('rejected_amount');
            $table->dropColumn('comment');
        });
    }
};
