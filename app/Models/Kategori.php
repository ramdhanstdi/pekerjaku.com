<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'name',
      'image',
      'description'
    ];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'kategori_id', 'id');
    }
}
