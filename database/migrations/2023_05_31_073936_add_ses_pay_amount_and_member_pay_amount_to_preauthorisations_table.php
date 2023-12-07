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
            $table->double('ses_pay_amount')->nullable()->after('amount_in_dollar');
            $table->double('member_pay_amount')->nullable()->after('ses_pay_amount');
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
            $table->dropColumn('ses_pay_amount');
            $table->dropColumn('member_pay_amount');
        });
    }
};
