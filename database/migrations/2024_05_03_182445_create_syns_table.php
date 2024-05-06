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
        Schema::create('syns', function (Blueprint $table) {
            $table->id();
            $table->string('source_id', 100);
            $table->string('source', 50);
            $table->string('sku', 200)->nullable();
            $table->string('name', 100)->nullable();
            $table->text('details');
            $table->bigInteger('user_id')->nullable();
            $table->string('status', 50)->default('new');
            $table->string('info', 200)->nullable();
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
        Schema::dropIfExists('syns');
    }
};
