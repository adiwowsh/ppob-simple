<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_history', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 120)->unique();
            $table->string('midtrans_token', 120)->nullable();
            $table->integer('user_id');
            $table->decimal('amount',20,0)->default(0);
            $table->string('payment_via', 120)->default('');
            $table->string('va_account', 120)->default('');
            $table->timestamp('paid_at')->nullable();
            $table->string('paid_with', 120)->default('');
            $table->string('paid_note', 120)->default('');
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('topup_history');
    }
}
