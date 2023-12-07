<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\ClaimAssessmentNote;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_assessment_notes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        ClaimAssessmentNote::insert([
            ['description' => 'Annual Benefits Exceeded'],
            ['description' => 'Not Covered Under Policy'],
            ['description' => 'Duplicate Invoice'],
            ['description' => 'Within Benefit Waiting Period'],
            ['description' => 'Paid Less Excess'],
            ['description' => 'Provider Negotiated Rates Exceeded'],
            ['description' => 'Discount Applied']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_assessment_notes');
    }
};
