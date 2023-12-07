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
        Schema::table('claims', function (Blueprint $table) {
            $table->foreignId('auth_type_id')->after('member_id')->nullable()->constrained('auth_types')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('service_provider_id')->after('member_id')->nullable()->constrained('service_providers')->references('service_provider_id')->onDelete('set null')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            //
        });
    }
};
