<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kategori_id',
        'name_lengkap',
        'no_telepon',
        'no_telepon_saudara',
        'address',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'umur',
        'status',
        'punya_anak',
        'pengalaman',
        'salary',
        'salary_min',
        'bersedia_bekerja',
        'jam_berapa_bisa_dihubungi'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Kategori','kategori_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
