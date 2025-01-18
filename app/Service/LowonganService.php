<?php

namespace App\Service;

use App\Repository\LowonganRepository;
use Illuminate\Http\Request;

class LowonganService {

  protected $lowonganRepository;
  protected $request;

  public function __construct(
    LowonganRepository $lowonganRepository,
    Request $request
  )
  {
    $this->lowonganRepository = $lowonganRepository;
    $this->request = $request;
  }

  public function getAlls(){
    return $this->lowonganRepository->getAll();
  }

  public function getOnes(){
    return $this->lowonganRepository->getAll();
  }

  public function getAll(){
    $data = $this->lowonganRepository->getAll();

    try {
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function getOne(){
    $id = $this->request->input('id');
    $data = $this->lowonganRepository->getOne($id);

    try {
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function save(){
    $params = $this->request->only([
        'id',
        'kategori_id',
        'name_lengkap',
        'no_telepon',
        'no_telepon_saudara',
        'address',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'umur',
        'status',
        'punya_anak',
        'pengalaman',
        'salary',
        'salary_min',
        'bersedia_bekerja',
        'jam_berapa_bisa_dihubungi'
    ]);

    if($this->request->file('image')){
      $file = $this->request->file('image');
      $extension = $file->getClientOriginalExtension();
      $name = time() .'.'. $extension;
      $path = $this->request->file('image')->storeAs('lowongan', $name, 'public');
    }

    $params['image'] = $path ?? '';

    $this->lowonganRepository->save($params);
    
    try {
      return response()->json([
        'status' => true,
        'message' => 'Data berhasil di simpan'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function delete(){
    $id = $this->request->input('id');
    $this->lowonganRepository->delete($id);
    try {
      return response()->json([
        'status' => true,
        'message' => 'Data berhasil di hapus'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}