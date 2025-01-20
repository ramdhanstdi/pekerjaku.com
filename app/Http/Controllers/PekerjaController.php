<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
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
        $kategori = $this->kategoriService->getAlls();
        $view1 = view('landingpage.pekerja', compact('kategori', 'pekerja')) -> render();
        $view2 = view('admin.pekerja.index', compact('pekerja')) -> render();
        return $view1 . $view2 ;
    }

    public function dashboard(){
        return view('pekerja.dashboard');
    }

    public function lowongan(){
        $kategori = $this->kategoriService->getAlls(); // Fetch kategori data
        return view('pekerja.lowongan', compact('kategori'));
    }

    public function dataDiri(){
        $userId = auth()->id(); // Get the authenticated user's ID
        $dataDiri = Pekerja::where('user_id', $userId)->first(); // Fetch the user's data
        $kategori = $this->kategoriService->getAlls(); // Fetch kategori data
        return view('pekerja.data_diri', compact('kategori', 'dataDiri'));
    }

    public function detailPekerja($id){
        $data = $this->pekerjaService->getOnes($id);
        $p = $this->pekerjaService->getALls()->where('id','!=', 1);
        $pekerja = collect($p)->take(4);
        return view('landingpage.detail', compact('data','pekerja'));
    }

    public function placeOrder(Request $request, $pekerjaId)
    {
        // Validate request
        $validated = $request->validate([
            'note' => 'nullable|string|max:255',
        ]);

        $pekerja = $this->pekerjaService->getOneByUserId($pekerjaId);
        $userPekerja = $this->usersService->getOne($pekerjaId);
      
        // Prepare data for the order
        $data = [
            'pekerja_id' => $pekerja->getData()->data->id,
            'user_id' => auth()->user()->id,
            'full_name' => auth()->user()->first_name.auth()->user()->last_name,
            'email' => auth()->user()->email,
            'address' => auth()->user()->address,
            'phone_number' => auth()->user()->phone_number,
            'status' => 'pending', // Default status
            'note' => $validated['note'] ?? null,
        ];

        // Place the order using the service
        $order = $this->orderService->placeOrder($data);

        // Redirect to WhatsApp with a message
        $message = urlencode("Saya ingin memesan pekerja dengan nama {$userPekerja} dan ID {$order->pekerja_id}");
        $whatsAppUrl = "https://wa.me/62895334930931?text=$message";

        return redirect($whatsAppUrl);
    }


    public function getAll(){
        return $this->pekerjaService->getAll();
    }

    public function getOne(){
        return $this->pekerjaService->getOne();
    }

    public function save(){
        return $this->pekerjaService->save();
    }

    public function delete(){
        return $this->pekerjaService->delete();
    }
}
