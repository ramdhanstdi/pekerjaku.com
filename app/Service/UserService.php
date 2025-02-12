<?php

namespace App\Service;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService {

  protected $userRepository;
  public $request;

  public function __construct(
    UserRepository $userRepository,
    Request $request
  )
  {
    $this->userRepository = $userRepository;
    $this->request = $request;
  }

  public function getAll(){
    $data = $this->userRepository->getAll();

    try {
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e
      ]);
    }
  }

  public function getAlls(){
    return $this->userRepository->getAll();
  }

  public function getOne(){
    $id = $this->request->input('id');

    $data = $this->userRepository->getOne($id);

    try {
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e
      ]);
    }
  }

  public function save(){
    $params = $this->request->only([
      'id',
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
    $year = date('Y');
    $params['image'] = $path;
    $lastPayment = DB::table('users')->latest('id')->first();

    if ($lastPayment && isset($lastPayment->payment_code)) {
        $lastId = (int) substr($lastPayment->payment_code, -6); // Extract last 6 digits
        $newId = str_pad($lastId + 1, 6, '0', STR_PAD_LEFT); // Increment and pad with zeros
    } else {
        $newId = '000001'; // Start from 000001 if no previous record exists
    }

    $paymentCode = $year . $newId;
    $params['payment_code'] = $paymentCode;
    $this->userRepository->save($params);

    try {
      return response()->json([
        'status' => true,
        'message' => 'Data berhasil di simpan'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e
      ]);
    }
  }

  public function delete(){
    $id = $this->request->input('id');

    $this->userRepository->delete($id);
    try {
      return response()->json([
        'status' => true,
        'message' => 'Data berahsail d hapus'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e
      ]);
    }
  }
}
