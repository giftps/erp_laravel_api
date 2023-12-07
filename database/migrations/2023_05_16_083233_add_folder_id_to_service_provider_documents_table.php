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
        Schema::table('service_provider_documents', function (Blueprint $table) {
            $table->foreignId('folder_id')->after('service_provider_id')->nullable()->constrained('service_provider_folders')->references('id')->onDelete('set null')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_provider_documents', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });
    }
};
