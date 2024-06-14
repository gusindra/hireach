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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('channel', 50);
            $table->string('provider', 50);
            $table->string('title', 100);
            $table->string('from', 50);
            $table->string('to')->comment('use audience if using audience_id');
            $table->string('text')->comment('use template if using template_id');
            $table->tinyInteger('is_otp')->default(0);
            $table->string('request_type', 50)->default("form")->comment('form, api');
            $table->tinyInteger('way_type')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('status', 50)->default('pending');
            $table->float('budget', 10, 2)->default(0.00);
            $table->foreignId('template_id')->nullable()->comment('template will used');
            $table->foreignId('audience_id')->nullable()->comment('audience will send');
            $table->foreignId('user_id')->comment('spesific executor & owner');
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
        Schema::dropIfExists('campaigns_tabel');
    }
};
