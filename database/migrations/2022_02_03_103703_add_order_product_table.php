<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('model', 255)->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->integer('qty')->default(0);
            $table->string('unit', 50)->nullable();
            $table->float('price', 12, 2)->default(0.00);
            $table->integer('total_percentage')->default(100);
            $table->string('note', 100)->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('order_products');
    }
}
