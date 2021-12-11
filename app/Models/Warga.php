<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_hp',
        'ktp',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
