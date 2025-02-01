<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Pekerja;
use App\Models\Review;
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
    

    public function dataPekerja(Request $request) {
        $userId = auth()->user()->id; // Get the authenticated user's ID
    
        // Fetch search and pagination parameters
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
    
        // Query orders with relationships and filter by status "bekerja"
        $dataOrderQuery = Order::with(['user', 'pekerja.user'])
            ->where('user_id', $userId)
            ->where('status', '=', 'bekerja'); // Corrected the where clause
    
        // Apply search filter if provided
        if ($search) {
            $dataOrderQuery->where(function ($query) use ($search) {
                $query->whereHas('pekerja.user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhere('number_whatsapp', 'like', "%{$search}%"); // Corrected field name
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%") 
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhere('number_whatsapp', 'like', "%{$search}%");
                });
            });
        }
    
        // Paginate results
        $dataOrder = $dataOrderQuery->paginate($perPage);
    
        // Modify each order object to include custom attributes safely
        $dataOrder->getCollection()->transform(function ($item) {
            $pekerjaUser = $item->pekerja->user ?? null;
            $majikanUser = $item->user ?? null;
    
            $item->fullNamePekerja = $pekerjaUser ? "{$pekerjaUser->first_name} {$pekerjaUser->last_name}" : 'N/A';
            $item->telpPekerja = $pekerjaUser->number_whatsapp ?? 'N/A';
            $item->fullNameMajikan = $majikanUser ? "{$majikanUser->first_name} {$majikanUser->last_name}" : 'N/A';
            $item->telpMajikan = $majikanUser->number_whatsapp ?? 'N/A';
    
            return $item;
        });
    
        return view('majikan.data_pekerja', compact('dataOrder'));
    }

    public function stopPekerja($id) {
        $order = Order::find($id);
    
        if ($order) {
            // Update order status to "berhenti"
            $order->update(['status' => 'selesai', 'note' => 'Pekerja telah selesai bekerja.']);
    
            // Update pekerja status and note
            Pekerja::where('id', $order->pekerja_id)->update([
                'employee_status' => 'tersedia',
            ]);
    
            return redirect()->route('majikan.data_pekerja')->with('success', 'Pekerja berhasil diberhentikan.');
        }
    
        return redirect()->route('majikan.data_pekerja')->with('error', 'Data pekerja tidak ditemukan.');
    }

    public function updateReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);
    
        // Find the existing review
        $review = Review::findOrFail($id);

        Order::where('reviews_id', $id)->update([
            'note' => 'Pekerja telah selesai bekerja dan di review oleh majikan.',
        ]);
    
        // Update review
        $review->update([
            'star' => $request->rating,
            'comment' => $request->review,
        ]);
    
        return redirect('majikan/data-order')->with('success', 'Review updated successfully.');
    }
    
    
}
