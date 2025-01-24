<?php

namespace App\Http\Controllers;
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
    

    public function dataPekerja(){
        return view('majikan.data_pekerja');
    }

    public function dataOrder(){
        return view('majikan.data_pesan');
    }
}
