<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusanSyarat extends Model
{
    use HasFactory;

    protected $table = 'pengurusan_syarat';

    protected $fillable = [
        'pengurusan_id',
        'syarat_id',
        'foto'
    ];

}
