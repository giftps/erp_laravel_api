<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\SchemeType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheme_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('identifier');
            $table->string('description');
            $table->timestamps();
        });

        SchemeType::insert([
            ['code' => 'IS-001', 'identifier' => 'TanzIndiv', 'description' => 'Tanzanite Individual'],
            ['code' => 'CS-001', 'identifier' => 'TanzCorp', 'description' => 'Tanzanite Corporate'],
            ['code' => 'MF-001', 'identifier' => 'TanzMng', 'description' => 'Tanzanite Managed Fund'],
            ['code' => 'IS-002', 'identifier' => 'Tanz+Indiv', 'description' => 'Tanzanite+Individual'],
            ['code' => 'CS-002', 'identifier' => 'Tanz+Indiv', 'description' => 'Tanzanite+Corporate'],
            ['code' => 'MF-002', 'identifier' => 'Tanz+Mng', 'description' => 'Tanzanite+Managed Fund'],
            ['code' => 'IS-003', 'identifier' => 'AmethInd', 'description' => 'Amethyst Individual'],
            ['code' => 'CS-003', 'identifier' => 'AmethCorp', 'description' => 'Amethyst Corporate'],
            ['code' => 'MF-003', 'identifier' => 'AmethMng', 'description' => 'Amethyst Managed Fund']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheme_types');
    }
};
