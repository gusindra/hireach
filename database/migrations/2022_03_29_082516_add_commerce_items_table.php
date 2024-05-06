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
        Schema::create('commerce_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku');
            $table->string('name');
            $table->string('spec');
            $table->string('source_id', 255)->nullable();
            $table->string('source', 255)->nullable();
            $table->string('type', 100)->nullable()->comment('sku, without_sku, one_time, monthly, annually');
            $table->string('unit', 100)->nullable();
            $table->text('description')->nullable();
            $table->double('general_discount', 8, 2)->nullable();
            $table->double('fs_price', 8, 2)->nullable();
            $table->double('unit_price', 8, 2);
            $table->string('way_import', 20)->nullable()->comment('fob, ddp');
            $table->string('status', 100)->default('active')->comment('active, disabled');
            $table->bigInteger('user_id')->default(0);
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
        Schema::dropIfExists('commerce_items');
    }
};
