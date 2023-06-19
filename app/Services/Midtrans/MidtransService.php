<?php

namespace App\Services\Midtrans;

use App\Repository\User\UserRepository;
use App\Services\Phone\PhoneService;
use Carbon\Carbon;
use Psy\Exception\ErrorException;

class MidtransService{

    public function proceedData($phone, $amount, $makeNewPayment = 0){
        $userRepo = new UserRepository();
        $phoneService = new PhoneService();
        $user = $userRepo->findUserByPhone($phone);
        if(!$user){
            return false;
        }

        $isExist = $userRepo->checkExisting($user->id, $amount);
        if($isExist AND !$makeNewPayment){

            $status = $this->getStatus($isExist->order_id);
            if($status AND !empty($status->transaction_status) AND $status->transaction_status == 'settlement'){
                // update to paid
                $userRepo->makePaid($isExist->order_id, $status->payment_type);
            }
            return $isExist;
        }

        if($isExist AND $makeNewPayment){
            $userRepo->makeExpired($isExist->user_id);
        }

        $orderId    = 'PPOB-' . Carbon::now()->timestamp;
        $fname  = $user->name;
        $phone  = $phoneService->validatePhone($user->phone);
        $email  = $user->email;

        //$midtrans_token  = $midtrans->requestSnapToken($amount, $orderId, $fname, '', $email, $phone);
        $midtransStart  = $this->requestSnapTokenUrl($amount, $orderId, $fname, env('BRAND_NAME'), $email, $phone);
        if(!$midtransStart){
            return false;
        }

        $via    = 'snap';
        $midtrans_token = $midtransStart;
        $va_account = ($via == 'snap') ? '' : $midtransStart['va_number'];

        return $userRepo->storeData($orderId, $midtrans_token, $user->id, $amount, $va_account, $via);
    }

    public function chargeByVaBNI($amount = 0, $orderId = '', $firstName = '', $lastName = 'Noname', $email = '', $phone = ''){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('MIDTRANS_PROD', false);
// Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $items = array(
            array(
                'id'       => $orderId,
                'price'    => $amount,
                'quantity' => 1,
                'name'     => 'Topup PPOB'
            )
        );

        $params = array(
            "payment_type" => "bank_transfer",
            "item_details" => $items,
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ),
            'customer_details' => array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
            ),
            'callbacks' => [
                "finish"    => 'midtrans-success'
            ],
            "bank_transfer" => [
                 "bank" => "bri",
                 //"va_number" => "12345678"
            ]
        );
        try{
            $response = \Midtrans\CoreApi::charge($params);
            if($response AND !empty($response->status_code) AND $response->status_code == 201){
                return [
                    'transaction_id'    => $response->transaction_id,
                    'va_number'         => $response->va_numbers[0]->va_number
                ];
            }
        }catch (ErrorException $err){

        }


        return false;
    }

    public function requestSnapTokenUrl($amount = 0, $orderId = '', $firstName = '', $lastName = 'Noname', $email = '', $phone = ''){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('MIDTRANS_PROD', false);
// Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ),
            'customer_details' => array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
            ),
            'callbacks' => [
                "finish"    => 'midtrans-success'
            ]
        );

        $snap = \Midtrans\Snap::getSnapUrl($params);
        return $snap;
    }
    public function getStatus($orderId = 0){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('MIDTRANS_PROD', false);
// Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $status = \Midtrans\Transaction::status($orderId);

        return $status;
    }
}
