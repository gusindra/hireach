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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->tinyInteger('loop_type')->default(0);
            $table->enum('shedule_type', ['none', 'daily', 'monthly', 'yearly'])->default('none');
        });
        Schema::table('campaigns_schedules', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('loop_type');
            $table->dropColumn('shedule_type');
        });
        Schema::table('campaigns_schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
