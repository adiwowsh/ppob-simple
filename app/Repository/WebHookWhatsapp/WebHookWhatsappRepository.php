<?php

namespace App\Repository\WebHookWhatsapp;

use App\Models\WebhookWhatsappReceiveMsg;
use App\Models\WebhookWhatsappReplyMsg;

class WebHookWhatsappRepository{
    public function storeReceive($type, $productId, $userId, $phone, $name = '', $messageType = 'text', $reply = ''){
        $store = new WebhookWhatsappReceiveMsg();
        $store->type = $type;
        $store->product_id = $productId;
        $store->user_id = $userId;
        $store->phone = $phone;
        $store->name = $name;
        $store->message_type = $messageType;
        $store->reply = $reply;
        $store->save();

        return $store;
    }

    public function storeReply($userId, $phone, $messageType = 'text', $text = ''){
        $store = new WebhookWhatsappReplyMsg();
        $store->user_id = $userId;
        $store->phone = $phone;
        $store->message_type = $messageType;
        $store->text = $text;
        $store->save();

        return $store;
    }
}
