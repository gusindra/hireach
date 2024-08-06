<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('no', 255)->nullable();
            $table->string('type', 255)->comment('Selling Product, SAAS Service, Referral');
            $table->string('entity_party', 255);
            $table->string('customer_type', 255)->nullable();
            $table->string('referrer_id', 255)->nullable();
            $table->string('commision_ratio', 255)->nullable();
            $table->string('total', 255)->nullable();
            $table->integer('vat')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('customer_id', 255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('source', 50)->default('');
            $table->string('source_id', 50)->default('');
            $table->timestamp('date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
