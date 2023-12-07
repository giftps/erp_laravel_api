<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\SuspensionLiftReason;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspension_lift_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        SuspensionLiftReason::insert([
            ['code' => 'APR', 'description' => 'Payment Received'],
            ['code' => 'AWP', 'description' => '25% Premium Received'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspension_lift_reasons');
    }
};
