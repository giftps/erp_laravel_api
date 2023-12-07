<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ClaimType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('description');
            $table->timestamps();
        });

        ClaimType::insert([
            ['type' => 'OP', 'description' => 'Out Patient'],
            ['type' => 'IP', 'description' => 'In Patient'],
            ['type' => 'Chronic', 'description' => 'Chronic Management'],
            ['type' => 'Maternity', 'description' => 'Maternity'],
            ['type' => 'CA', 'description' => 'Cancer Treatment'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_types');
    }
};
