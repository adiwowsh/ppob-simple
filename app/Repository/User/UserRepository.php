<?php

namespace App\Repository\User;

use App\Models\TopupHistory;
use App\Models\User;
use App\Services\Phone\PhoneService;
use Carbon\Carbon;

class UserRepository{
    public function findUserByPhone($phone = ''){
        $phoneService = new PhoneService();
        return User::where('phone', $phoneService->validatePhone($phone))
            ->first();
    }

    public function create($email, $phone, $name, $password, $city){
        $user = User::where('email', $email)
            ->first();
        if($user){
            return $user;
        }
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($password),
            'city' => $city
        ]);

        return $user;
    }
    public function updatePassword($phone, $password){
        $user = User::where('phone', $phone)
            ->first();
        if(!$user){
            return false;
        }

        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    public function checkExisting($userId = '', $amount = 0){
        $existingData = TopupHistory::where('user_id', $userId)
            ->where('amount', $amount)
            ->whereNull('paid_at')
            ->orderBy('updated_at','desc')
            ->first();

        if($existingData){
            $timestamp = Carbon::parse($existingData->expired_at); // Replace with your actual timestamp
            if(!$timestamp->isPast()){
                return $existingData;
            }
        }

        return false;
    }

    public function storeData($orderId, $midtrans_token, $user_id, $amount, $va_account = '', $via = 'va_bni'){
        // check existing BUT different amount, so make it expired
        $existingData = TopupHistory::where('user_id', $user_id)
            ->whereNotNull('paid_at')
            ->orderBy('updated_at','desc')
            ->first();

        if($existingData){
            $existingData->expired_at   = Carbon::now();
            $existingData->save();
        }


        // create new
        $timestamp = Carbon::now(); // Replace with your actual timestamp
        $newTimestamp = $timestamp->addDays(1);
        $new    = new TopupHistory();
        $new->order_id = $orderId;
        $new->midtrans_token = $midtrans_token;
        $new->user_id = $user_id;
        $new->amount = $amount;
        $new->payment_via = $via; // VA BNI Default
        $new->va_account = $va_account;
        $new->expired_at = $newTimestamp;

        return $new;
    }


    public function makePaid($orderId, $paidWith = ''){
        $topupHistory = TopupHistory::where('order_id', $orderId)
            ->whereNull('paid_at')
            ->first();

        if(!$topupHistory){
            return false;
        }

        $topupHistory->paid_at = Carbon::now();
        $topupHistory->paid_with = $paidWith;
        $topupHistory->save();

        return $topupHistory;
    }


    public function makeExpired($user_id){
        // check existing BUT different amount, so make it expired
        $existingData = TopupHistory::where('user_id', $user_id)
            ->whereNotNull('paid_at')
            ->orderBy('updated_at','desc')
            ->first();

        if($existingData){
            $existingData->expired_at   = Carbon::now();
            $existingData->save();
        }
    }

}
