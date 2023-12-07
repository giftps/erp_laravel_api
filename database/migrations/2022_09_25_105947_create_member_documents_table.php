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
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->references('member_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->text('path');
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
        Schema::dropIfExists('member_documents');
    }
};
