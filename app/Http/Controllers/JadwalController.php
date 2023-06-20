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

    public function index()
    {
        $title = "Data Jadwal";
        $jadwals = Jadwal::orderBy('id', 'asc')->paginate();
        return view('jadwals.index', compact(['jadwals', 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Jadwal";
        return view('jadwals.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai',
            'jam_selesai',
        ]);

        Jadwal::create($request->post());

        return redirect()->route('jadwals.index')->with('success', 'Jadwal has been created successfully.');
    }

    public function edit(Jadwal $jadwal)
    {
        $title = "Edit Data Jadwal";
        return view('jadwals.edit', compact(['jadwal', 'title']));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai',
            'jam_selesai',
        ]);

        $jadwal->fill($request->post())->save();

        return redirect()->route('jadwals.index')->with('success', 'Jadwal Has Been updated successfully');
    }


    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwals.index')->with('success', 'Jadwal has been deleted successfully');
    }

    public function exportExcel(){
        return Excel::download(new ExportJadwal, 'jadwals.xlsx');
    }
}
