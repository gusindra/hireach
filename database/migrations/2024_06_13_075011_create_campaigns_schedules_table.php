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
        Schema::create('campaigns_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('month')->default(1);
            $table->string('day');
            $table->timeTz('time', precision: 0);
            $table->foreignId('campaign_id')->comment('own of table');
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
        Schema::dropIfExists('campaigns_schedules');
    }
};
