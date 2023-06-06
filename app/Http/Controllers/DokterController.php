<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {   
        $title = "Data Dokter";
        $dokters = Dokter::orderBy('id','asc')->paginate(5);
        return view('dokters.index', compact(['dokters' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Dokter";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('dokters.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required',
        ]);

        $dokter = [
            'id_dokter' => $request->id_dokter,
            'nama_dokter' => $request->nama_dokter,
            'bulan' => $request->bulan,
            'spesialisasi' => $request->spesialisasi,
        ];
        for ($i=1; $i <= 2; $i++) {
            $details = [

            ];
        }

        dd($request);
        
        Dokter::create($request->post());

        return redirect()->route('dokters.index')->with('success','Departement has been created successfully.');
    }

    public function show(Dokter $dokter)
    {
        return view('dokters.show',compact('Departement'));
    }

    public function edit(Dokter $dokter)
    {
        $title = "Edit Data Dokter";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('dokters.edit',compact('departement' , 'title', 'managers'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'manager_id' => 'required',
        ]);
        
        $dokter->fill($request->post())->save();

        return redirect()->route('dokters.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokters.index')->with('success','Departement has been deleted successfully');
    }

}
