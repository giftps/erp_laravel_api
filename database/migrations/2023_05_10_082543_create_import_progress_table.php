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
        Schema::create('import_progress', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('total_records')->default(0);
            $table->double('processed_records')->default(0);
            $table->double('percentage_complete')->default(0);
            $table->json('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_progress');
    }
};
