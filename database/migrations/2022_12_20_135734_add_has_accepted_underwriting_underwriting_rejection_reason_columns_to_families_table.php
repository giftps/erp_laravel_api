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
            $table->boolean('underwriting_accepted')->default(false)->after('is_underwritten');
            $table->text('underwriting_rejection_reason')->nullable()->after('underwriting_accepted');
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
            $table->dropColumn('underwriting_accepted');
            $table->dropColumn('underwriting_rejection_reason');
        });
    }
};
