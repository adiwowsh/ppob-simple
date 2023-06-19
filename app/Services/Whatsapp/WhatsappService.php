<?php

namespace App\Services\Whatsapp;

use App\Models\User;
use App\Models\WebhookWhatsappReceiveMsg;
use App\Repository\User\UserRepository;
use App\Repository\WebHookWhatsapp\WebHookWhatsappRepository;
use App\Services\Helpers;
use App\Services\Midtrans\MidtransService;
use App\Services\Phone\PhoneService;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;



class WhatsappService{
    public function start($payload){
        $helpers = new Helpers();
        $phoneValidate = new PhoneService();
        $userRepo = new UserRepository();
        $midtrans = new MidtransService();
        // Parsing and Store here
        $data = $this->_parsingAndStoreData($payload);
        if(strtolower($data->text) == 'saldo'){
            return $this->_checkBalance($data);
        }
        if(strtolower($data->text) == 'history'){
            return $this->_history($data);
        }

        if(strtolower($data->text) == 'help'){
            return $this->_help($data);
        }

        if($helpers->containsWord('pulsa', strtolower($data->text))){
            return $this->_default($data);
        }

        if($helpers->containsWord('pln', strtolower($data->text))){
            return $this->_default($data);
        }

        if($helpers->containsWord('plnbill', strtolower($data->text))){
            return $this->_default($data);
        }

        if($helpers->containsWord(strtolower("REG"), $data->text) AND $helpers->containsWord(env('PRIVATE_PIN'), $data->text)){
            // REGISTER USER HERE
            // Example format
            // REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN
            $explodedTxt = $this->_explodeText($data->text);
            if(!$explodedTxt){
                // error

                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, pesan untuk pendaftaran salah, silahkan menggunakan contoh format beriku \n
REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN"
                ];
            }

            // continue register validation
            if(count($explodedTxt) < 6){
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, pesan untuk pendaftaran salah, silahkan menggunakan contoh format beriku \n
REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN"
                ];
            }

            // Validate phone
            $phone = $explodedTxt[1];
            if(!$phoneValidate->validatePhone($phone)){
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, nomor hp tidak valid, silahkan menggunakan contoh format beriku  \n
REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN"
                ];
            }

            // Validate email
            $email = $explodedTxt[2];
            $validator = Validator::make(['email' => $email], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, email tidak valid, silahkan menggunakan contoh format beriku  \n
REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN"
                ];
            }

            // Validate PIN
            $pin = $explodedTxt[5];
            if($pin != env('PRIVATE_PIN')){
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, PIN salah, silahkan menggunakan contoh format beriku  \n
REG#083833833988#rorobawa@gmail.com#Ari Tumiwa#Sumbawa#PIN"
                ];
            }

            // Store
            $password = mt_rand(1000, 9999);
            $phone = $phoneValidate->validatePhone($phone);
            $user = $userRepo->findUserByPhone($phone);
            $exist = true;
            if(!$user){
                $exist = false;
                $user = $userRepo->create($email, $phone, $explodedTxt[3], $password, $explodedTxt[4]);
            }

            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Agen Yth
Pendaftaran Anda SUKSES.
Selamat bergabung dengan " . env('BRAND_NAME') . "\n 
Nomor akun Anda " . $user->phone . "
PIN/Password Anda " . (!$exist ? $password : 'Hubungi Admin') . "
Saldo Rp" . number_format($user->balance, 0) . "
Untuk info pembelian dan topup saldo Hub.
" . env('CS_WA')
            ];

        }

        if($helpers->containsWord('UPDATE', strtolower($data->text)) AND $helpers->containsWord(env('PRIVATE_PIN'), $data->text)){
            // UPDATE PIN/PASS USER HERE
            // Example format
            // UPDATE#083833833988#ADMIN_PIN
            $explodedTxt = $this->_explodeText($data->text);
            if(!$explodedTxt){
                // error

                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, data update salah, silahkan menggunakan contoh format beriku \n
UPDATE#083833833988#ADMIN_PIN"
                ];
            }


            // Validate phone
            $phone = $phoneValidate->validatePhone($explodedTxt[1]);
            // Store
            $password = mt_rand(1000, 9999);
            $phone = $phoneValidate->validatePhone($phone);
            $user = $userRepo->findUserByPhone($phone);
            if(!$user){
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, user tidak ditemukan \n
UPDATE#083833833988#ADMIN_PIN"
                ];
            }
            $user = $userRepo->updatePassword($phone, $password);

            // Success update
            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Agen Yth
Update sandi Anda SUKSES.
Selamat bergabung dengan " . env('BRAND_NAME') . "\n 
Nomor akun Anda " . $user->phone . "
PIN/Password Anda " . $password . "
Saldo Rp" . number_format($user->balance, 0) . "
Untuk info pembelian dan topup saldo Hub.
" . env('CS_WA')
            ];
        }

        if($helpers->containsWord('topup', strtolower($data->text))){
            $explodedTxt = $this->_explodeText($data->text);
            if(!$explodedTxt){
                // error
                return $this->_help($data);
            }

            if(!is_array($explodedTxt) OR count($explodedTxt) < 2){
                return $this->_help($data);
            }
            $amount = $explodedTxt[1];
            $amount = preg_replace("/[^0-9]/", "", $amount);
            if($amount < env('MIN_TOPUP')){
                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, minimal topup adalah Rp" . env('MIN_TOPUP') . "
silahkan ulangi permintaan Anda
Ketik TOPUP#NOMINAL_TOPUP (contoh TOPUP#300000) untuk mengisi saldo \n"
                ];
            }

            // Check if user exist
            $user = $userRepo->findUserByPhone($data->phone);
            if(!$user){

                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => "Maaf, anda belum terdaftar, silahkan hubungi kami " . env('CS_WA') . " untuk prosed pendaftaran"
                ];
            }

            // process topup
            $midtransResult = $midtrans->proceedData($user->phone, $amount, 1);
            if($midtransResult){
                $vaAccount = $midtransResult->va_account;

                $messageVa = "Permintaan isi saldo sebesar Rp" . number_format($midtransResult->amount, 0) . " telah berhasil
dengan nomor invoice #". $midtransResult->order_id ."
Silahkan transfer ke REKENING VIRTUAL ACCOUNT berikut \n \n
BANK: BNI
NO VA: " . $vaAccount . "
A/N: " . $user->name . " " . env('BRAND_NAME') . "
NOMINAL: Rp" . number_format($midtransResult->amount) . "
KODE BANK: 009 \n \n
Proses konfirmasi akan otomatis tanpa memerlukan manual check oleh admin";

                $messageSnap = "Permintaan isi saldo sebesar Rp" . number_format($midtransResult->amount, 0) . " telah berhasil
dengan nomor invoice #". $midtransResult->order_id ."
Kami menerima pembayaran via Virtual account, Gopay, QR dll
Silahkan transfer melalui link berikut \n \n
". $midtransResult->midtrans_token ."  \n \n
Proses konfirmasi akan otomatis tanpa memerlukan manual check oleh admin";

                $messageManual = "Permintaan isi saldo sebesar Rp" . number_format($midtransResult->amount, 0) . " telah berhasil
dengan nomor invoice #". $midtransResult->order_id ."
Kami menerima pembayaran via Transfer bank \n \n
BANK: ". env('CS_BANK') ."
NO REK: " . env('CS_BANK_REK') . "
A/N: " . env('CS_BANK_NAME') . "
NOMINAL: Rp" . number_format($midtransResult->amount) . "
KODE BANK: 009 \n \n
Proses konfirmasi akan otomatis tanpa memerlukan manual check oleh admin";

                $textMsg = "";
                switch (env('CS_TRANSFER_METHOD')){
                    case "snap":
                        $textMsg = $messageSnap;
                        break;
                    case "va":
                        $textMsg = $messageVa;
                        break;
                    default:
                        $textMsg = $messageManual;
                        break;
                }

                return [
                    'status'    => true,
                    'data' => $data,
                    'message'   => $textMsg
                ];
            }

            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Proses topup terkendala, silahkan hubungi Admin untu topup manual ke " . env('CS_WA')
            ];

        }

        return [
            'status'    => true,
            'data' => $data,
            'message'   => "Maaf, kami tidak mengenali pesan Anda, silahkan coba ketik \n
HELP \n
untuk info command yang dapat kami kerjakan"
        ];
    }

    public function sendMessage($toNumber, $type, $message, $replyUrl = '', $userId = '', $productId = '', $phoneId = ''){
        $whatsappRepo = new WebHookWhatsappRepository();
        $client = new Client();

        $url = ($replyUrl ? $replyUrl : env('MAYTAPI_URL') . $productId . '/' . $phoneId);

        $data = [
            'to_number' => $toNumber,
            'type' => $type,
            'message' => $message
        ];

        try {
            $response = $client->post($url, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-maytapi-key' => env('MAYTAPI_TOKEN'),
                ],
            ]);

            //$statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents());
            if($responseData AND !empty($responseData->success) AND $responseData->success){

                $user = $whatsappRepo->storeReply($userId, $toNumber, $type, $message);
                return $user;
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the request
        }

        return false;
    }

    private function _explodeText($string){
        $helpers = new Helpers();
        if(!$helpers->containsWord("#", $string)){
            return false;
        }

        try{
            // Explode the string by "#"
            $parts = explode('#', $string);

            // Initialize the result array
            $result = [];

            // Process each part and create a separate array for each word group
            foreach ($parts as $part) {
                // Remove leading and trailing whitespace
                $trimmedString = trim($part);

                // Skip empty parts
                if (!empty($trimmedString)) {
                    // Add the part to the result array
                    $result[] = $trimmedString;
                }
            }
            return $result;
        }catch (ErrorException $errorException){
            return false;
        }
    }

    private function _parsingAndStoreData($payload){
        $phoneService = new PhoneService();
        $data = new WebhookWhatsappReceiveMsg(); // Create a new empty object
        if(!empty($payload->type) AND $payload->type == 'message'){
            // continue
            $data->message_type = $payload->message->type;
            if($data->message_type == 'text'){
                $data->type = $payload->type;
                $data->product_id = $payload->product_id;
                $data->user_id = $payload->user->id;
                $data->phone = $phoneService->validatePhone($payload->user->phone);
                $data->name = $payload->user->name;
                $data->text = $payload->message->text;
                $data->reply = $payload->reply;
                $data->save();

                return $data;
            }
            return false;
        }

        return false;
    }

    private function _help($data){
        return [
            'status'    => true,
            'data' => $data,
            'message'   => "Ketik SALDO untuk cek saldo Anda \n
Ketik TOPUP#NOMINAL_TOPUP
(contoh TOPUP#300000) untuk mengisi saldo \n
Ketik PULSA#NOMINAL#NOMOR_HP
(contoh PULSA#081213456778#25000) untuk mengisi pulsa \n
Ketik PLN#NOMINAL#NOMOR_METER
(contoh PLN#25000#776887998) untuk mengisi Token Listrik PLN \n
Ketik PLNBILL#NOMOR_METER
(contoh PLNBILL#776887998) untuk cek tagihan dan bayar listrik PLN bulanan \n
Ketik HISTORY
untuk mengetahui riwayat/history penggunaan saldo Anda"
        ];
    }

    private function _default($data){
        $phoneService = new PhoneService();
        $user   = User::where('phone', $phoneService->validatePhone($data->phone))
            ->first();

        if(!$user){
            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Maaf, Anda belum terdaftar, silahkan hubungi Admin untuk mendaftarkan akun Anda. WA " . env('CS_WA')
            ];
        }

        return [
            'status'    => true,
            'data' => $data,
            'message'   => "Saldo Anda sebesar 
Rp " . number_format($user->balance, 0) . " \n
Silahkan topup dahulu untuk dapat menggunakan fitur ini
Silahkan ketik \n
TOPUP#NOMINAL_TOPUP
(contoh TOPUP#300000) untuk mengisi saldo 
dan mulai mendapatkan keuntungan untuk jadi agen kami"
        ];
    }

    private function _checkBalance($data){
        $phoneService = new PhoneService();
        $user   = User::where('phone', $phoneService->validatePhone($data->phone))
            ->first();

        if(!$user){
            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Maaf, Anda belum terdaftar, silahkan hubungi Admin untuk mendaftarkan akun Anda. WA " . env('CS_WA')
            ];
        }

        return [
            'status'    => true,
            'data' => $data,
            'message'   => "Saldo Anda sebesar 
Rp " . number_format($user->balance, 0) . " \n
silahkan ketik
TOPUP#NOMINAL_TOPUP
(contoh TOPUP#300000) untuk mengisi saldo 
dan mulai mendapatkan keuntungan untuk jadi agen kami"
        ];
    }

    private function _history($data){
        $phoneService = new PhoneService();
        $user   = User::where('phone', $phoneService->validatePhone($data->phone))
            ->first();

        if(!$user){
            return [
                'status'    => true,
                'data' => $data,
                'message'   => "Maaf, Anda belum terdaftar, silahkan hubungi Admin untuk mendaftarkan akun Anda. WA " . env('CS_WA')
            ];
        }
        return [
            'status'    => true,
            'data' => $data,
            'message'   => "Anda belum pernah melakukan topup
silahkan ketik
TOPUP#NOMINAL_TOPUP
(contoh TOPUP#300000) untuk mengisi saldo 
dan mulai mendapatkan keuntungan untuk jadi agen kami"
        ];

    }
}
