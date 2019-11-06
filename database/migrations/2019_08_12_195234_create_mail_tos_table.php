<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_tos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_id');
            $table->foreign('mail_id')->references('mail_id')->on('mail_messages');
            $table->string('display')->nullable();
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_tos');
    }
}
