<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookWhatsappReceiveMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_whatsapp_receive_msg', function (Blueprint $table) {
            $table->id();
            $table->string('type',64);
            $table->string('product_id',64)->default('');
            $table->string('user_id',64)->default('');
            $table->string('phone',64)->default('');
            $table->string('name',64)->default('');
            $table->string('message_type',64)->default('');
            $table->text('text')->nullable();
            $table->string('reply',240)->default('');
            $table->string('timestamp',64)->nullable();
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
        Schema::dropIfExists('webhook_whatsapp_receive_msg');
    }
}
