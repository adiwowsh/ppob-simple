<?php

namespace App\Http\Controllers;

use App\Repository\User\UserRepository;
use App\Services\Phone\PhoneService;
use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    protected $whatsappService, $phoneService, $userRepo;
    public function __construct(WhatsappService $whatsappService, PhoneService $phoneService, UserRepository $userRepo)
    {
        $this->whatsappService = $whatsappService;
        $this->phoneService = $phoneService;
        $this->userRepo = $userRepo;
    }

    public function index(Request $request){
        return view('index');
    }

    public function account(Request $request){
        if(!Auth::check()){
            return redirect(url('login'));
        }
        $user = Auth::user();
        return view('account', compact('user'));
    }

    public function topup(Request $request){
        if(!Auth::check()){
            return redirect(url('login'));
        }

        $user = Auth::user();
        return view('topup', compact('user'));
    }

    public function productPlnToken(Request $request){

        return view('pln-token-product');
    }

    public function productPlnPascabayar(Request $request){

        return view('pln-pascabayar-product');
    }

    public function productPulsa(Request $request){

        return view('pulsa-product');
    }

    public function register(Request $request){

        return view('register');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request){

        return view('login');
    }

    public function loginPost(Request $request){
        $validatedData = $request->validate([
            'phone' => 'required|numeric',
            'password' => 'required',
        ], [
            'phone.required' => 'Please enter your phone number.',
            'phone.numeric' => 'Please enter a valid phone number.',
            'password.required' => 'Please enter your password.',
        ]);

        $phone = $this->phoneService->validatePhone($request->get('phone'));
        $password = $request->get('password');
        $credentials = [
            'phone' => $phone,
            'password' => $password
        ];


        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/');
        } else {
            // Invalid user or password
            return back()->withErrors(['login' => 'Invalid phone number or password.'])->withInput();
        }
    }

    public function waLanding(Request $request){
        return view('wa-landing');
    }
}
