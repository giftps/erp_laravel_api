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
        Schema::create('scheme_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained('years')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('scheme_option_id')->constrained('scheme_options')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('age_group_id')->nullable()->constrained('age_groups')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('subscription_period_id')->nullable()->constrained('subscription_periods')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('amount')->nullable();
            $table->double('tax_percentage')->nullable();
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
        Schema::dropIfExists('scheme_subscriptions');
    }
};
