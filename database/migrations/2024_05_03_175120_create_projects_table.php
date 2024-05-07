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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('type', 50)->nullable()->comment('Selling Product, SAAS Service, Referral');
            $table->bigInteger('entity_party')->nullable();
            $table->string('party_b', 50)->nullable();
            $table->string('product_line', 50)->nullable();
            $table->string('customer_name', 50)->nullable();
            $table->string('customer_address', 50)->nullable();
            $table->string('customer_type', 50)->nullable();
            $table->string('referrer_name', 50)->nullable();
            $table->string('commission_ratio', 50)->nullable();
            $table->string('team_id', 50)->nullable();
            $table->string('status', 50)->default('draft')->comment('draft > submit > approve / revise');
            $table->string('contact_id', 50)->nullable();
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
        Schema::dropIfExists('projects');
    }
};
