<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter', 
        'nama_dokter', 
        'bulan',
        'spesialisasi',
    ];
}
