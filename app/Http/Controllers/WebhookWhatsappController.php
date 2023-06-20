<?php

namespace App\Http\Controllers;

use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;

class WebhookWhatsappController extends Controller
{
    protected $whatsappService;
    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function receiveMessage(Request $request)
    {
        $payloads = $request->json()->all();
        $result = $this->whatsappService->start(json_decode(json_encode($payloads)));

        if($result['status'] AND !empty($result['data']) AND !empty($result['message'])){
            // reply message
            $messageData = $result['data'];
            $result['message'] = $result['message'] . '/n' . 'Pesan ID ' . time();
            $replyMessage = $this->whatsappService->sendMessage($messageData->phone, 'text', $result['message'], $messageData->reply, $messageData->user_id);

            return response()->json($replyMessage);
        }

        return response()->json([
            'status' => false,
            'message' => "Something wrong 10031"
        ]);
    }
}
