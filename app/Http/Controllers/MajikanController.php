<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;

class MajikanController extends Controller
{
    public function index(){
        return view('majikan.dashboard');
    }

    public function dataDiri(){
        $userId = auth()->user()->id; // Get the authenticated user's ID
        $dataDiri = User::where('id', $userId)->first(); // Fetch the user's data
        return view('majikan.data_diri', compact('dataDiri'));
    }

    public function save(Request $request)
    {
        $user = auth()->user();
    
        // Validate the request
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'selfie_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $dataToUpdate = [];
    
        // Handle file uploads
        if ($request->hasFile('image')) {
            $dataToUpdate['image'] = $request->file('image')->store('uploads/users', 'public');
        }
    
        if ($request->hasFile('ktp')) {
            $dataToUpdate['ktp'] = $request->file('ktp')->store('uploads/ktp', 'public');
        }
    
        if ($request->hasFile('selfie_ktp')) {
            $dataToUpdate['selfie_ktp'] = $request->file('selfie_ktp')->store('uploads/selfie_ktp', 'public');
        }
    
        // Update the user record
        $user->update($dataToUpdate);
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }
    

    public function dataOrder(Request $request)
    {
        $userId = auth()->user()->id; // Get the authenticated user's ID
    
        // Fetch search and pagination parameters
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
    
        // Query orders with relationships
        $dataOrderQuery = Order::with(['user', 'pekerja.user'])
            ->where('user_id', $userId); // Get only the orders of the authenticated user
    
        // Apply search filter if provided
        if ($search) {
            $dataOrderQuery->whereHas('pekerja.users', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%") // Search by pekerja's name
                      ->orWhere('phone', 'like', "%{$search}%"); // Search by pekerja's phone number
            })->orWhereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%") 
                      ->orWhere('last_name', 'like', "%{$search}%") // Search by ordering user's name
                      ->orWhere('phone', 'like', "%{$search}%"); // Search by ordering user's phone number
            });
        }

        // Paginate results
        $dataOrderQuery->where('employee_status', '==', 'active');

        $dataOrder = $dataOrderQuery->paginate($perPage);

        // Modify each order object to include custom attributes
        $dataOrder->getCollection()->transform(function ($item) {
            $item->fullNamePekerja = $item->pekerja->user->first_name ?? 'N/A';
            $item->telpPekerja = $item->pekerja->user->number_whatsapp ?? 'N/A';
            $item->fullNameMajikan = $item->user->first_name ?? 'N/A';
            $item->telpMajikan = $item->user->number_whatsapp ?? 'N/A';
            return $item;
        });
    
        return view('majikan.data_pesan', compact('dataOrder'));
    }
    

    public function dataPekerja(Request $request){
        $userId = auth()->user()->id; // Get the authenticated user's ID
    
        // Fetch search and pagination parameters
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
    
        // Query orders with relationships
        $dataOrderQuery = Order::with(['user', 'pekerja.user'])
            ->where('user_id', $userId); // Get only the orders of the authenticated user
    
        // Apply search filter if provided
        if ($search) {
            $dataOrderQuery->whereHas('pekerja.users', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%") // Search by pekerja's name
                      ->orWhere('phone', 'like', "%{$search}%"); // Search by pekerja's phone number
            })->orWhereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%") 
                      ->orWhere('last_name', 'like', "%{$search}%") // Search by ordering user's name
                      ->orWhere('phone', 'like', "%{$search}%"); // Search by ordering user's phone number
            });
        }

        // Paginate results
        $dataOrder = $dataOrderQuery->paginate($perPage);

        // Modify each order object to include custom attributes
        $dataOrder->getCollection()->transform(function ($item) {
            $item->fullNamePekerja = $item->pekerja->user->first_name.' '.$item->pekerja->user->last_name ?? 'N/A';
            $item->telpPekerja = $item->pekerja->user->number_whatsapp ?? 'N/A';
            $item->fullNameMajikan = $item->user->first_name.' '.$item->user->last_name ?? 'N/A';
            $item->telpMajikan = $item->user->number_whatsapp ?? 'N/A';
            return $item;
        });

        return view('majikan.data_pekerja', compact('dataOrder'));
    }
}
