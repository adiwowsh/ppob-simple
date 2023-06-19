<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookWhatsappReceiveMsg extends Model
{
    use HasFactory;
    protected $table    = 'webhook_whatsapp_receive_msg';
    public $timestamps = true;
}
