<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_messages', function (Blueprint $table) {
            $table->bigIncrements('mail_id');
            $table->timestamp('created_at');
            $table->string('file_name');
            $table->string('message_id')->unique();
            $table->string('subject');
            $table->integer('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_messages');
    }
}
