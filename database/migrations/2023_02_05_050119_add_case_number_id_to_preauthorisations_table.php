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
        Schema::table('preauthorisations', function (Blueprint $table) {
            $table->foreignId('case_number_id')->nullable()->after('member_id')->constrained('preauthorisations')->references('id')->cascadeOnUpdate()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preauthorisations', function (Blueprint $table) {
            $table->dropForeign(['case_number_id']);
            $table->dropColumn('case_number_id');
        });
    }
};
