<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];

    protected $fillable = [
        'nama',
    ];

    public function syarat()
    {
        return $this->belongsToMany(Syarat::class, 'surat_syarat', 'surat_id', 'syarat_id', 'id', 'id');
    }
}
