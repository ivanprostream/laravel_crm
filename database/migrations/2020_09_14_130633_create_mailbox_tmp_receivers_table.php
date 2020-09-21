<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailboxTmpReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailbox_tmp_receivers', function (Blueprint $table) {
            $table->id();
            $table->integer('mailbox_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->timestamps();

            $table->foreign('mailbox_id')->references('id')->on('mailbox')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailbox_tmp_receivers');
    }
}
