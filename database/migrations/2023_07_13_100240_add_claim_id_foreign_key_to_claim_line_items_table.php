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
            $table->foreignId('claim_id')->after('id')->constrained('claims')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
            $table->dropForeign(['claim_id']);
            $table->dropColumn('claim_id');
        });
    }
};
