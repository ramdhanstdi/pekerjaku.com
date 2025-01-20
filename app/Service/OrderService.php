<?php

namespace App\Service;

use App\Repository\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAlls(){
        return $this->orderRepository->getAll();
    }

    /**
     * Place a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     */
    public function placeOrder(array $data)
    {
        $data['user_id'] = Auth::id(); // Add the logged-in user's ID
        return $this->orderRepository->save($data);
    }

    /**
     * Get all orders for the logged-in user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserOrders()
    {
        return $this->orderRepository->getone(Auth::id());
    }
}
