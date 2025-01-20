<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'pekerja_id',
        'full_name',
        'email',
        'address',
        'phone_number',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class);
    }
}
