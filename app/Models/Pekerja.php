<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'kategori_id',
        'age',
        'experience',
        'education',
        'tall',
        'heavy',
        'date_of_birth',
        'tribe_of_origin',
        'police_letter',
        'doctors_letter',
        'marital_status',
        'salary',
        'admin_fees',
        'warranty_period',
        'stay_at',
        'have_children',
        'religion',
        'current_location',
        'fear_of_dogs',
        'work_experience_abroad',
        'english',
        'skills',
        'willing_to_work_in',
        'employee_status',
        'skill',
        'description'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function kategori(){
        return $this->belongsTo('App\Models\Kategori', 'kategori_id');
    }
}
