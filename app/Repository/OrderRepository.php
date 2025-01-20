<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository
{
    protected $model;

    public function __construct(
        Order $model
    ){
      $this->model = $model;
    }

 
    public function getAll(){
        return $this->model->get();
    }
    
    public function getAllWithUsersAndPekerjas()
    {
        return Order::with(['user', 'pekerja'])->get();
    }
    
    public function getOne($id){
        return $this->model->where('id', $id)->first();
    }
    
    public function save($params){
        if (!empty($params['id'])) {
        $order = $this->model->where('id', $params['id'])->update($params);
        } else {
        $order = $this->model->create($params);
        }
        return $order;
    }
    
    public function delete($id){
        return $this->model->where('id', $id)->delete();
    }
}
