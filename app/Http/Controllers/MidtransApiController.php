<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\User\UserRepository;
use App\Services\Midtrans\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Phone\PhoneService;
use App\Models\TopupHistory;

class MidtransApiController extends Controller
{
    //
    protected $userRepo, $midtransService;

    public function __construct(UserRepository $userRepo, MidtransService $midtransService)
    {
        $this->userRepo = $userRepo;
        $this->midtransService = $midtransService;
    }

    public function callSuccess(Request $request){
        $orderId = $request->get('order_id');
        $status = $this->midtransService->getStatus($orderId);
        if(!$status){
            return response([
                'message'   => "Pembayaran belum diterima / gagal"
            ]);
        }
        if($status->transaction_status == 'settlement'){
            // update to success

            $this->userRepo->makePaid($orderId);
            return response([
                'message'   => "Pembayaran sukses"
            ]);
        }

        return response([
            'message'   => "Pembayaran tertahan sementara"
        ]);
    }

    public function callNow(Request $request){
        $phone  = $request->get('phone', '');
        $amount = $request->get('amount', 300000);
        $makeNewPayment = $request->get('make_new', 0);

        $topupHistory = $this->midtransService->proceedData($phone, $amount, $makeNewPayment);
        if(!$topupHistory){
            return response([
                'message'   => "User tidak ditemukan"
            ]);
        }
        $transaction_token = $topupHistory->midtrans_token;

        return response($topupHistory);

        //return view('midtrans.payment', compact('transaction_token'));

    }
}
