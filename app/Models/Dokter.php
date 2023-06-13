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

    public function detail()
    {
        return $this->hasMany(Detail::class, 'id_dokter', 'id_dokter');
    }

    public function getManager()
    {
        return $this->belongsTo(User::class, 'nama_dokter', 'id');
    }
}
