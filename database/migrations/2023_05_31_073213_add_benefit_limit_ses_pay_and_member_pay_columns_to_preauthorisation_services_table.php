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
        Schema::table('preauthorisation_services', function (Blueprint $table) {
            $table->double('benefit_limit_amount')->after('amount_in_dollar');
            $table->double('ses_pay_amount')->after('benefit_limit_amount');
            $table->double('member_pay_amount')->after('ses_pay_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preauthorisation_services', function (Blueprint $table) {
            $table->dropColumn('benefit_limit_amount');
            $table->dropColumn('ses_pay_amount');
            $table->dropColumn('member_pay_amount');
        });
    }
};
