<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\DependentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependent_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('description');
            $table->timestamps();
        });

        DependentType::insert([
            ['type' => 'P', 'description' => 'Principal'],
            ['type' => 'S', 'description' => 'Spouse'],
            ['type' => 'D', 'description' => 'Dependent']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dependent_types');
    }
};
