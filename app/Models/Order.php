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
        'reviews_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id'); // The user who placed the order
    }

    public function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'pekerja_id'); // The hired worker
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'reviews_id');
    }
}
