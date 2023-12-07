<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ModusOperandi;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modus_operandis', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        ModusOperandi::insert([
            ['description' => 'Standard Annual Limit'],
            ['description' => 'Unit Limit'],
            ['description' => 'Bi-Annual Limit'],
            ['description' => 'Lifetime Limit'],
            ['description' => 'Managed Fund Limit']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modus_operandis');
    }
};
