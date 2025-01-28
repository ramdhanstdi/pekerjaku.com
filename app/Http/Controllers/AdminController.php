<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use App\Models\User;
use App\Models\Order;
use App\Service\KategoriService;
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
    protected $kategoriService;

    public function __construct(
        PekerjaService $pekerjaService,
        UserService $userService,
        LowonganService $lowonganService,
        KategoriService $kategoriService,
        OrderService $orderService
    ){
        $this->pekerjaService = $pekerjaService;
        $this->userService = $userService;
        $this->lowonganService = $lowonganService;
        $this->orderService = $orderService;
        $this->kategoriService = $kategoriService;
    }

    public function index(){
        return view('admin.dashboard');
    }

    public function pekerja(Request $request){
        // Initialize the query for the Pekerja model
        $pekerjaQuery = Pekerja::join('users', 'pekerjas.user_id', '=', 'users.id')
                        ->leftJoin('kategoris', 'pekerjas.kategori_id', '=', 'kategoris.id') // Join kategori if needed
                        ->select(
                            'pekerjas.*',
                            'users.first_name',
                            'users.last_name',
                            'users.email',
                            'users.number_whatsapp',
                            'users.regency_city',
                            'users.level_user',
                            'kategoris.name as kategori_name'
                        )
                        ->where('users.level_user', 3); // Assuming 'level_user' is the column in the users table   
    
        // Fetch filters and sorting from the request
        $search = $request->input('search'); // For filtering by search
        $sortBy = $request->input('sort_by', 'id'); // Default sorting column
        $sortOrder = $request->input('sort_order', 'desc'); // Default sorting order
        $perPage = $request->input('per_page', 10); // Default pagination size
        $categoryId = $request->input('category_id'); // Category filter
    
        // Apply search filter if provided
        if ($search) {
            $pekerjaQuery->where(function ($query) use ($search) {
                // Search in related 'user' table for first_name and last_name
                $query->whereHas('pekerja.users', function ($usersQuery) use ($search) {
                    $usersQuery->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%"); // Assuming 'email' is in the users table
                })
                // Search in related 'kategori' table for category name
                ->orWhereHas('kategori', function ($kategoriQuery) use ($search) {
                    $kategoriQuery->where('name', 'like', "%{$search}%"); // Assuming 'name' is the column in the kategori table
                });
            });
        }
    
        // Apply category filter if provided
        if ($categoryId) {
            $pekerjaQuery->where('kategori_id', $categoryId); // Assuming 'category_id' is a foreign key in the Pekerja model
        }
    
        // Apply the condition for level_user = 3 (adjust for the correct relationship)
        $pekerjaQuery->whereHas('user', function ($query) {
            $query->where('level_user', 3); // Assuming 'user' is a relationship in the Pekerja model
        });
    
        // Get total count before pagination
        $totalPekerjaCount = $pekerjaQuery->count();
    
        // Apply sorting and paginate results
        $pekerja = $pekerjaQuery->orderBy($sortBy, $sortOrder)->paginate($perPage);
    
        // Fetch categories
        $kategori = $this->kategoriService->getAlls();

        return view('admin.pekerja.index', compact('pekerja', 'kategori', 'totalPekerjaCount'));
    }

    public function user(Request $request)
    {
        // Fetch filters and sorting from the request
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'users.id'); // Default sorting column
        $sortOrder = $request->input('sort_order', 'desc'); // Default sorting order
        $perPage = $request->input('per_page', 10); // Default pagination size
    
        // Query for users
        $userQuery = User::query();
    
        // Apply search filter if provided
        if ($search) {
            $userQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('regency_city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%");
            });
        }

        $userQuery->where('level_user', '!=', 1);
    
        // Get total count before pagination
        $totalUserCount = $userQuery->count();
    
        // Apply sorting and paginate results
        $users = $userQuery->orderBy($sortBy, $sortOrder)->paginate($perPage);
    
        return view('admin.user.index', compact('users', 'totalUserCount'));
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
            $order->telpPekerja = $order->pekerja->user->number_whatsapp;
            $order->telpMajikan = $order->user->number_whatsapp;
            return $order;
        });

        return view('admin.order.index', compact('orders'));
    }
    
    public function rejectOrder($id) {
        $order = Order::find($id);
    
        if ($order) {
            // Update order status
            $order->update(['status' => 'rejected']);
    
            // Update pekerja status using pekerja_id from the order
            Pekerja::where('id', $order->pekerja_id)->update(['employee_status' => 'tersedia']);
    
            // Redirect with success message
            return redirect()->route('admin.order')->with('success', 'Order rejected successfully!');
        }
    
        return redirect()->route('admin.order')->with('error', 'Order not found!');
    }
    
    public function confirmOrder($id) {
        $order = Order::find($id);
    
        if ($order) {
            // Update the selected order status to "bekerja"
            $order->update(['status' => 'bekerja', 'note' => 'Order telah dikonfirmasi']);
    
            // Reject all other orders with the same pekerja_id that have status "pending"
            Order::where('pekerja_id', $order->pekerja_id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected', 'note' => 'Order lain telah dikonfirmasi']);
    
            // Update pekerja status to "bekerja"
            Pekerja::where('id', $order->pekerja_id)->update([
                'employee_status' => 'bekerja',
            ]);
    
            // Redirect with success message
            return redirect()->route('admin.order')->with('success', 'Order confirmed successfully! Other pending orders for this worker were rejected.');
        }
    
        return redirect()->route('admin.order')->with('error', 'Order not found!');
    }
    
}
