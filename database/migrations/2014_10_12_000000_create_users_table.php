<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Hash;

use App\Models\Api\V1\UserAccess\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->foreignId('role_id')->constrained('roles')->references('role_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('unique_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('confirmation_code')->nullable();
            $table->integer('failed_login_count')->default(0);
            $table->boolean('can_login')->default(true);
            $table->timestamp('can_login_after')->nullable();
            $table->string('password_reset_code')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        \App\Models\User::insert([
            ['unique_id' => '00001', 'first_name' => 'Enock', 'last_name' => 'Soko', 'role_id' => Role::where('name', '=', 'Super Admin')->first()->role_id, 'email' => 'enock.soko@ses-unisure.com', 'phone_number' => '260974519270', 'is_active' => true, 'password' => Hash::make('12345678')],
            ['unique_id' => '00002', 'first_name' => 'Etienne', 'last_name' => 'Greeff', 'role_id' => Role::where('name', '=', 'Super Admin')->first()->role_id, 'email' => 'etienne@ses-unisure.com', 'phone_number' => '260970000000', 'is_active' => true, 'password' => Hash::make('12345678')]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
