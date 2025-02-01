<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pekerja;
use App\Models\Review;
use App\Service\KategoriService;
use App\Service\PekerjaService;
use App\Service\UserService;
use App\Service\OrderService;
use Illuminate\Http\Request;

class PekerjaController extends Controller
{
    protected $pekerjaService;
    protected $kategoriService;
    protected $usersService;
    protected $orderService;

    public function __construct(
        PekerjaService $pekerjaService,
        KategoriService $kategoriService,
        UserService $userService,
        OrderService $orderService,
    )
    {
        $this->usersService = $userService;
        $this->kategoriService = $kategoriService;
        $this->pekerjaService = $pekerjaService;
        $this->orderService = $orderService;
    }
        
    public function index(){
        $pekerja = $this->pekerjaService->getAlls()->where('user.level_user', 3);
        return view('admin.pekerja.index', compact('pekerja')) -> render();
    }

    public function pekerja(Request $request)
    {
        // Initialize the query for the Pekerja model
        $pekerjaQuery = Pekerja::query();
    
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
                $query->whereHas('user', function ($usersQuery) use ($search) {
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
    
        // Apply sorting and paginate results, including reviews
        $pekerja = $pekerjaQuery
        ->with('reviews')  // Eager load reviews
        ->orderBy($sortBy, $sortOrder)
        ->paginate($perPage);

    
        // Fetch the latest 5 records
        $pekerjaBaru = Pekerja::whereHas('user', function ($query) {
            $query->where('level_user', 3); // Assuming 'user' is a relationship in the Pekerja model
        })
        ->orderBy('id', 'desc')
        ->take(5)
        ->get();
    
        // Fetch categories
        $kategori = $this->kategoriService->getAlls();
    
        // Return view with data
        return view('landingpage.pekerja', compact('kategori', 'pekerja', 'pekerjaBaru', 'totalPekerjaCount'));
    }
    

    public function dashboard(){
        return view('pekerja.dashboard');
    }

    public function lowongan(){
        $kategori = $this->kategoriService->getAlls(); // Fetch kategori data
        return view('pekerja.lowongan', compact('kategori'));
    }

    public function dataDiri(){
        $userId = auth()->user()->id; // Get the authenticated user's ID
        $dataDiri = Pekerja::where('user_id', $userId)->first(); // Fetch the user's data
        $kategori = $this->kategoriService->getAlls(); // Fetch kategori data
        return view('pekerja.data_diri', compact('kategori', 'dataDiri'));
    }

    public function detailPekerja($id)
    {
        // Get the pekerja with related reviews
        $data = $this->pekerjaService->getOnes($id);
        $reviews = $data->reviews()->with('user')->get()->where('comment', '!=', null); // Fetch reviews with comments
        $avgStar = $reviews->avg('star'); // Calculate average star rating
    
        // Fetch other pekerja excluding the current one
        $p = $this->pekerjaService->getAlls()->where('id', '!=', $id);
        $pekerja = collect($p)->take(4);
    
        // Return view with data and reviews
        return view('landingpage.detail', compact('data', 'pekerja', 'reviews' ,'avgStar'));
    }
    

    public function placeOrder(Request $request, $pekerjaId)
    {
        // Validate request
        $validated = $request->validate([
            'note' => 'nullable|string|max:255',
        ]);
    
        $pekerja = $this->pekerjaService->getOneByUserId($pekerjaId);
        $userPekerja = User::where('id', $pekerjaId)->first();
        $name = $userPekerja->first_name . ' ' . $userPekerja->last_name;
        // Create a new review entry linked to the order
        $review = Review::create([
            'user_id' => auth()->user()->id,
            'full_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'pekerja_id' => $pekerja->getData()->data->id,
            'star' => 0, // Default null, to be updated later
            'rating' => null, // Default null, to be updated later
            'comment' => null, // Default null, to be updated later
        ]);
    
        // Prepare data for the order
        $data = [
            'pekerja_id' => $pekerja->getData()->data->id,
            'user_id' => auth()->user()->id,
            'full_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'email' => auth()->user()->email,
            'address' => auth()->user()->address,
            'phone_number' => auth()->user()->phone_number,
            'status' => 'pending', // Default status
            'note' => 'Menunggu konfirmasi Admin', // Default note
            'reviews_id' => $review->id, // Default note
        ];
    
        // Place the order using the service
        $order = $this->orderService->placeOrder($data);
    
        // Redirect to WhatsApp with a message
        $message = urlencode("Saya ingin memesan pekerja dengan nama {$name} dengan ID Order {$order->id}");
        $whatsAppUrl = "https://wa.me/" . env('WHATSAPP_CONTACT') . "?text=$message";
    
        return redirect($whatsAppUrl);
    }
    


    public function getAll(){
        return $this->pekerjaService->getAll();
    }

    public function getOne(){
        return $this->pekerjaService->getOne();
    }

    public function save(Request $request){
        // save data model
        $attributes = ['user_id' => auth()->user()->id];

        Pekerja::updateOrCreate($attributes, $request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil di simpan'
          ]);
    }

    public function delete(){
        return $this->pekerjaService->delete();
    }
}
