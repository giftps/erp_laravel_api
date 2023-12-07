<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\AgeGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('age_groups', function (Blueprint $table) {
            $table->string('code')->after('id');
        });

        $age_groups = AgeGroup::all();
        $count = 0;
        foreach($age_groups as $group){
            $age_group = AgeGroup::find($group->id);
            $code = null;
            if($count < 10){
                $code = "0$count";
            }else{
                $code = "$count";
            }
            $age_group->code = $code;
            $age_group->save();

            $count = $count + 1;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('age_groups', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
