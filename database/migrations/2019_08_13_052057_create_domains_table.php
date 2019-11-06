<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->bigIncrements('domain_id');
            $table->timestamps();
            $table->string('name');
            $table->date('expiry_date')->nullable();
            $table->enum('added_by', ['admin', 'user'])->default('user');
            $table->timestamp('mx_checked_at')->nullable();
            $table->enum('type', ['receive', 'send', 'send_receive'])->default('receive');
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
