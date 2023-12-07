<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ExclusionCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exclusion_codes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        ExclusionCode::insert([
            ['description' => 'Hypertension'],
            ['description' => 'Cardiac Condition'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exclusion_codes');
    }
};
