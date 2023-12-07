<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\FlagType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flag_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        FlagType::insert([
            ['code' => 'M', 'description' => 'Member'],
            ['code' => 'I', 'description' => 'Individual'],
            ['code' => 'C', 'description' => 'Company'],
            ['code' => 'Mng', 'description' => 'Managed Fund'],
            ['code' => 'D', 'description' => 'Doctor'],
            ['code' => 'S', 'description' => 'Scheme']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flag_types');
    }
};
