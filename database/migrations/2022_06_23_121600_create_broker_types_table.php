<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broker_types', function (Blueprint $table) {
            $table->bigIncrements('broker_type_id');
            $table->string('name');
            $table->timestamps();
        });

        \App\Models\Api\V1\Lookups\BrokerType::insert([
            ['name' => 'SES-Broker'],
            ['name' => 'Reseller-Broker'],
            ['name' => 'Online-Broker'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broker_types');
    }
};
