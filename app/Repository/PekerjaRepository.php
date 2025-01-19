<?php

namespace App\Repository;

use App\Models\Pekerja;

class PekerjaRepository {

  protected $model;

  public function __construct(
    Pekerja $model
  )
  {
    $this->model = $model;
  }

  public function getAll(){
    return $this->model->with(['user','kategori'])->get();
  }

  public function getOne($id){
    return $this->model->with(['user','kategori'])->where('id', $id)->first();
  }

  public function save($params){ 
    if (!empty($params['user_id'])) {
      $user  = $this->model->where('user_id', $params['user_id'])->update($params);
    } else {
      $user = $this->model->create($params);
    }
    return $user;
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }
}