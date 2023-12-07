<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Api\V1\Lookups\Department;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Department::insert([
            ['name' => 'Membership'],
            ['name' => 'Claims'],
            ['name' => 'Call Center'],
            ['name' => 'Sales & Marketing'],
            ['name' => 'Finance'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
