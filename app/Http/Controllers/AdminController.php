<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\PekerjaService;
use App\Service\UserService;
use App\Service\LowonganService;
use App\Service\OrderService;

class AdminController extends Controller
{

    protected $pekerjaService;
    protected $userService;
    protected $lowonganService;
    protected $orderService;

    public function __construct(
        PekerjaService $pekerjaService,
        UserService $userService,
        LowonganService $lowonganService,
        OrderService $orderService
    ){
        $this->pekerjaService = $pekerjaService;
        $this->userService = $userService;
        $this->lowonganService = $lowonganService;
        $this->orderService = $orderService;
    }

    public function index(){
        return view('admin.dashboard');
    }

    public function pekerja(){
        $pekerja = $this->pekerjaService->getAlls();
        return view('admin.pekerja.index', compact('pekerja'));
    }

    public function user(){
        $user = $this->userService->getAlls();
        return view('admin.user.index', compact('user'));
    }

    public function lowongan(){
        $lowongan = $this->lowonganService->getAlls();
        return view('admin.lowongan.index', compact('lowongan'));
    }

    public function order(){
        // Fetch all orders with user and pekerja information
        $orders = $this->orderService->getAlls();

        // Process each order to include fullNameMajikan and fullNamePekerja
        $orders = $orders->map(function ($order) {
            $order->fullNameMajikan = $order->user->first_name . ' ' . $order->user->last_name;
            $order->fullNamePekerja = $order->pekerja->user->first_name . ' ' . $order->pekerja->user->last_name;
            return $order;
        });

        return view('admin.order.index', compact('orders'));
    }


}
