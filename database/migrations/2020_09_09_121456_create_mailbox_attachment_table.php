<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailboxAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailbox_attachment', function (Blueprint $table) {
            $table->id();
            $table->integer('mailbox_id')->unsigned();
            $table->string('attachment');
            $table->timestamps();
 
            $table->foreign('mailbox_id')->references('id')->on('mailbox')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailbox_attachment');
    }
}
