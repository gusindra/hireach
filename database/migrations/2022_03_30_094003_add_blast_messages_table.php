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
        Schema::create('blast_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('msg_id', 50);
            $table->unsignedBigInteger('user_id');
            $table->string('client_id', 50)->comment('client id');
            $table->string('sender_id', 50);
            $table->string('type', 50);
            $table->string('status', 100)->nullable()->comment('DELIVERED, SENDING');
            $table->string('code', 100)->nullable();
            $table->tinyInteger('otp')->default(0);
            $table->string('message_content', 185);
            $table->string('balance', 100);
            $table->string('currency', 100)->nullable();
            $table->float('price', 8, 2)->default(0.00);
            $table->string('msisdn', 100);
            $table->tinyInteger('provider')->default(1);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blast_messages');
    }
};
