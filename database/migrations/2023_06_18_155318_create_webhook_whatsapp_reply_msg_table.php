<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookWhatsappReplyMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_whatsapp_reply_msg', function (Blueprint $table) {
            $table->id();
            $table->string('phone',64)->default('');
            $table->string('user_id',64)->default('');
            $table->string('product_id',64)->default('');
            $table->string('message_type',64)->default('');
            $table->text('text')->nullable();
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
        Schema::dropIfExists('webhook_whatsapp_reply_msg');
    }
}
