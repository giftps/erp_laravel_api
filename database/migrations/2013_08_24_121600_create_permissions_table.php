<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Api\V1\UserAccess\Permission;

use App\Models\Api\V1\UserAccess\Module;
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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->references('module_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('role_id')->constrained('roles')->references('role_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('can_add')->default(false);
            $table->boolean('can_edit')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->timestamps();
        });

        Permission::insert([
            ['module_id' => Module::where('name', '=', 'All')->first()->module_id, 'role_id' => Role::where('name', '=', 'Super Admin')->first()->role_id, 'can_add' => true, 'can_edit' => true, 'can_delete' => true]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
