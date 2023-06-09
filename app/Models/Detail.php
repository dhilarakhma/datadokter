<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter', 
        'id_jadwal', 
        'tempat_praktik',
        'keterangan',
    ];

    public function getJadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }
}
