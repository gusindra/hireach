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
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('commerce_id');
            $table->string('source_id')->nullable();
            $table->string('model', 100)->nullable()->comment('base on ext: project or manual');
            $table->string('model_id', 50)->nullable()->comment('address to id');
            $table->text('terms');
            $table->float('discount');
            $table->float('price');
            $table->string('status', 100)->default('draft')->comment('active, disabled');
            $table->foreignId('user_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamp('valid_until')->nullable();
            $table->string('addressed_company', 50)->nullable();
            $table->string('description', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('created_role', 50)->nullable();
            $table->string('addressed_name', 50)->nullable();
            $table->string('addressed_role', 50)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->integer('valid_day')->nullable();
            $table->date('date')->nullable();
            $table->string('quote_no', 50)->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
