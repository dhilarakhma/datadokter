<?php

namespace App\Http\Controllers;
use App\Models\Departements;
use App\Models\User;
use Illuminate\Http\Request;


class DepartementsController extends Controller
{
    public function index()
    {
        $title = "Data Departement";
        $departements = Departements::orderBy('id', 'asc')->paginate(5);
        return view('departements.index', compact(['departements', 'title']));
    }

    public function create() 
    {
        $title = "Tambah Data Departement";
        $managers = User::where('position', '1')->get();
        return view('departements.create', compact(['managers', 'title']));
    }


    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'name' => 'required',
        'location' => 'nullable',
        'manager_id' => 'required',
    ]);

    Departements::create($validatedData);

    return redirect()->route('departements.index')->with('success', 'Departement created successfully.');
    }


    public function show(Departements $departement)
    {
        return view('departements.show', compact('departement'));
    }


    public function edit(Departements $departement)
    {
        $title = "Edit Data Departement";
        $managers = User::where('position', '1')->orderBy('id', 'asc')->get();
        return view('departements.edit', compact(['managers','departement', 'title']));
    }


    public function update(Request $request, Departements $departement)
    {
        $request->validate([
            'name' => 'required',
            'location', 
            'manager_id' => 'required',
        ]);

        $departement->fill($request->post())->save();

        return redirect()->route('departements.index')->with('success', 'Departement Has Been updated successfully');
    }


    public function destroy(Departements $departement)
    {
        $departement->delete();
        return redirect()->route('departements.index')->with('success', 'Departement has been deleted successfully');
    }
}
