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
        $view1 = view('landingpage.lowongan', compact('lowongan'))->render();
        $view2 = view('admin.lowongan.index', compact('lowongan'))->render();
        $view3 = view('pekerja.lowongan', compact('kategori')) -> render();
        return $view1 . $view2 . $view3;
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
