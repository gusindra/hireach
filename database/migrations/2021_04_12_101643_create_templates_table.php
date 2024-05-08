<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('description');
            $table->string('trigger_condition')->default('equals');
            $table->string('trigger')->nullable();
            $table->smallInteger('order')->default(1);
            $table->foreignId('error_template_id')->nullable();
            $table->foreignId('template_id')->nullable();
            $table->unsignedSmallInteger('resource')->default(1);
            $table->boolean('is_enabled')->default(1);
            $table->unsignedSmallInteger('is_repeat_if_error')->nullable();
            $table->unsignedSmallInteger('is_wait_for_chat')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('templates');
    }
}
