<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;
    protected $request;

    public function __construct(
        AuthService $authService,
        Request $request
    )
    {
        $this->authService = $authService;
        $this->request = $request;
    }

    public function login(){
        return $this->authService->login();
    }

    public function registrasi(){
        return $this->authService->registrasi();
    }

    public function loginPage(){
        return view('auth.login');
    }

    public function loginPost(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
    
        $messages = [
            'email.required' => 'Please enter an email.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter a password.'
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }
    
        $credentials = $request->only('email', 'password');
    
        try {
            if (auth()->attempt($credentials)) {
                $request->session()->regenerate();
                $user = auth()->user();
                $token = $user->createToken('token-api')->plainTextToken;
    
                return response()->json([
                    'status' => true,
                    'data' => $user,
                    'access_token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    

    public function registerPage(){
        return view('auth.registrasi');
    }

    public function logout(){
        $this->request->user()->tokens()->delete();

        // Logout pengguna dari sesi web (untuk otentikasi berbasis sesi)
        auth()->logout();

        // Redirect ke halaman login atau lainnya
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
