<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookWhatsappReplyMsg extends Model
{
    use HasFactory;
    protected $table    = 'webhook_whatsapp_reply_msg';
    public $timestamps = true;
}
