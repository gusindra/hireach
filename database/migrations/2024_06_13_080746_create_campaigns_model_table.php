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
        Schema::create('campaign_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->comment('own of table');
            $table->string('model', 50)->comment('blast_message, request');
            $table->bigInteger('model_id');
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
        Schema::dropIfExists('campaign_models');
    }
};
