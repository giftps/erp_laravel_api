<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\SchemeOption;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheme_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tier_level');
            $table->string('member_types');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        SchemeOption::insert([
            ['name' => 'Tanzanite', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Tanzanite+', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Amethyst', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Amethyst+', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Bronze', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Silver', 'tier_level' => 1, 'member_types' => 'corporate'],
            ['name' => 'Sapphire', 'tier_level' => 1, 'member_types' => 'individual/corporate'],
            ['name' => 'Amber', 'tier_level' => 1, 'member_types' => 'individual/corporate'],
            ['name' => 'Chrome', 'tier_level' => 1, 'member_types' => 'individual/corporate'],
            ['name' => 'Gold', 'tier_level' => 2, 'member_types' => 'corporate'],
            ['name' => 'Gold+', 'tier_level' => 1, 'member_types' => 'individual/corporate'],
            ['name' => 'Platinum+', 'tier_level' => 1, 'member_types' => 'individual/corporate'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheme_options');
    }
};
