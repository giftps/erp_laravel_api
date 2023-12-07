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
            $table->boolean('is_invoice_accepted')->after('underwriting_rejection_reason')->default(false);
            $table->text('invoice_rejection_reason')->after('is_invoice_accepted')->nullable();
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
            $table->dropColumn('is_invoice_accepted');
            $table->dropColumn('invoice_rejection_reason');
        });
    }
};
