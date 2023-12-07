<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\Title;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Title::insert([
            ['name' => 'Mr'],
            ['name' => 'Mrs'],
            ['name' => 'Sir'],
            ['name' => 'Ms'],
            ['name' => 'Miss'],
            ['name' => 'Dr'],
            ['name' => 'Professor']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titles');
    }
};
