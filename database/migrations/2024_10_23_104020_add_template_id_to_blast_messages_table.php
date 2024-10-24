<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdToBlastMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blast_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->after('id'); // Letakkan di posisi yang diinginkan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blast_messages', function (Blueprint $table) {
            $table->dropColumn('template_id');
        });
    }
}
