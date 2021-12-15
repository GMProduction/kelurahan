<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurusan extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    protected $fillable = [
        'status',
    ];

    public function syarat()
    {
        return $this->hasMany(PengurusanSyarat::class, 'pengurusan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class,'surat_id');
    }
}
