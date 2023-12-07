<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ResignCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resign_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        ResignCode::insert([
            ['code' => 'API', 'description' => 'As Per Insurer'],
            ['code' => 'CC', 'description' => 'Change Renewal Cover Date'],
            ['code' => 'DEC', 'description' => 'Deceased'],
            ['code' => 'Dup', 'description' => 'Duplicate Member'],
            ['code' => 'FS', 'description' => 'Financial Situation'],
            ['code' => 'LC', 'description' => 'Left the Country'],
            ['code' => 'LCO', 'description' => 'Left the Company'],
            ['code' => 'MOI', 'description' => 'Moved to Other Insurer'],
            ['code' => 'R', 'description' => 'Resign'],
            ['code' => 'ST', 'description' => 'Scheme Transfer']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resign_codes');
    }
};
