<?php

namespace App\Service;

use App\Repository\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthService {
  protected $authRepository;
  protected $request;

  public function __construct(
    Request $request,
    AuthRepository $authRepository
  )
  {
    $this->authRepository = $authRepository;
    $this->request = $request;
  }

  public function login(){
    $rules= [
      'email' => 'required',
      'password' => 'required'
    ];

    $messages= [
        'email.required' => 'Please enter a email.',
        'password.required' => 'Please enter a password.'
    ];

    $validator = Validator::make($this->request->all(),$rules,$messages);
    if($validator->fails())
    {
        $messages=$validator->messages();
        $errors=$messages->all();

        return response()->json([
            'status' => false,
            'message' => $errors
        ]);
    }

    $data = [
        'email' => $this->request->email,
        'password' => $this->request->password
    ];

    try {
        if (auth()->attempt($data)) {
            $this->request->session()->regenerate();
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
                'message' => 'Username / Password salah'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
  }

  public function registrasi(){
    $params = $this->request->only([
      'first_name',
      'last_name',
      'email',
      'password',
      'address',
      'district',
      'regency_city',
      'province',
      'postal_code',
      'phone_number',
      'number_whatsapp',
      'level_user',
    ]);

    if($this->request->file('image')){
      $file = $this->request->file('image');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('image')->storeAs('images', $name, 'public');
    }
    $params['image'] = $path ?? '';

    if($this->request->file('ktp')){
      $file = $this->request->file('ktp');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('ktp')->storeAs('ktps', $name, 'public');
    }
    $params['ktp'] = $path ?? '';
    
  
    if($this->request->file('selfiektp')){
      $file = $this->request->file('selfiektp');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('selfiektp')->storeAs('selfiektps', $name, 'public');
    }
    $params['selfiektp'] = $path ?? '';

    if($this->request->file('skck')){
      $file = $this->request->file('skck');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('skck')->storeAs('skcks', $name, 'public');
    }
    $params['skck'] = $path ?? '';

    if($this->request->file('ijazah')){
      $file = $this->request->file('ijazah');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('ijazah')->storeAs('ijazahs', $name, 'public');
    }
    $params['ijazah'] = $path ?? '';

    $this->authRepository->registrasi($params);

    try {
      return response()->json([
        'status' => true,
        'message' => 'Account berhasil di daftarkan'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e
      ]);
    }
  }

  public function updatePayment($userId) {
    $rules = [
        'buktibayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    $messages = [
        'buktibayar.required' => 'Payment proof is required.',
        'buktibayar.mimes' => 'Only jpg, jpeg, png, or pdf files are allowed.',
        'buktibayar.max' => 'File size should not exceed 2MB.',
    ];

    $validator = Validator::make($this->request->all(), $rules, $messages);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->all()
        ]);
    }

    $params = [];
    if ($this->request->file('buktibayar')) {
        $file = $this->request->file('buktibayar');
        $extension = $file->getClientOriginalExtension();
        $name = time() . '.' . $extension;
        $path = $file->storeAs('buktibayars', $name, 'public');
        $params['buktibayar'] = $path ?? '';
    }
    $params['buktibayar'] = $path ?? '';

    $params['pay'] = true;

    try {
        $this->authRepository->update($userId, $params);

        return response()->json([
            'status' => true,
            'message' => 'Payment updated successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
  }
}
