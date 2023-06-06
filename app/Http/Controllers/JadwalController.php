<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function autocomplete(Request $request)
    {
        $data = Jadwal::select("hari as value", "id")
                    ->where('hari', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function show(Jadwal $jadwal)
    {
        return response()->json($jadwal);
    }
}
