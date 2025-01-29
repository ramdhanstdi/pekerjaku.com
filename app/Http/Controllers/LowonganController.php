<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Service\KategoriService;
use App\Service\LowonganService;
use Illuminate\Http\Request;

class LowonganController extends Controller
{   

    protected $lowonganService;
    protected $kategoriService;

    public function __construct(
        LowonganService $lowonganService,
        KategoriService $kategoriService,
    )
    {
        $this->lowonganService = $lowonganService;
        $this->kategoriService = $kategoriService;
    }

    public function index(){
        $lowongan = Lowongan::with('kategori')->get();
        $kategori = $this->kategoriService->getAlls();
        return view('landingpage.lowongan', compact('kategori'))->render();
    }

    public function getAll(){   
        return $this->lowonganService->getAll();
    }   

    public function getOne(){
        return $this->lowonganService->getOne();
    }
    
    public function save(){
        return $this->lowonganService->save();
    }

    public function delete(){
        return $this->lowonganService->delete();
    }
}
