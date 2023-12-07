<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Api\V1\Membership\Group;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->string('code');
            $table->string('office_number')->nullable();
            $table->string('nuit')->nullable();
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->string('group_size')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone_number')->nullable();
            $table->date('join_date')->nullable();
            $table->string('group_type');
            $table->string('status')->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
