<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use App\Charts\DokterLineChart;

class DokterController extends Controller
{
    public function index()
    {   
        $title = "Data Dokter";
        $dokters = Dokter::orderBy('id','asc')->get();
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
            'id_dokter' => 'required'
        ]);

        $dokter = [
            'id_dokter' => $request->id_dokter,
            'nama_dokter' => $request->nama_dokter,
            'bulan' => $request->bulan,
            'spesialisasi' => $request->spesialisasi,
        ];
        if($result = Dokter::create($dokter)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'id_dokter' => $request->id_dokter,
                    'id_jadwal' => $request['id_jadwal'.$i],
                    'tempat_praktik' => $request['tempat_praktik'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('dokters.index')->with('success','Dokter has been created successfully.');
    }

    public function show(Dokter $dokter)
    {
        return view('dokters.show',compact('Departement'));
    }

    public function edit(Dokter $dokter)
    {
        $title = "Edit Data Dokter";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = Detail::where('no_dokter', $dokter->id_dokter)->orderBy('id','asc')->get();
        return view('dokters.edit',compact('dokter' , 'title', 'managers', 'detail'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $dokters = [
            'id_dokter' => $request->id_dokter,
            'nama_dokter' => $request->nama_dokter,
            'bulan' => $request->bulan,
            'spesialisasi' => $request->spesialisasi,
            // 'total' => $request->total,
        ];
        if ($dokter->fill($dokters)->save()){
            Detail::where('no_dok', $dokter->id_dokter)->delete();
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_dok' => $dokter->id_dokter,
                    'id_jadwal' => $request['id_jadwal'.$i],
                    'nama_dokter' => $request['nama_dokter'.$i],
                    'bulan' => $request['bulan'.$i],
                    'spesialisai' => $request['spesialisai'.$i],
                    'tempat_praktik' => $request['tempat_praktik'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('dokters.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokters.index')->with('success','Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Dokter";
        $dokters = Dokter::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('dokters.pdf', compact(['dokters', 'title']));
        return $pdf->stream('laporan-dokters-pdf');
    }

    public function chartLine()
    {
        $api = url(route('dokters.chartLineAjax'));
   
        $chart = new DokterLineChart;
        $chart->labels(['Ibu dan Anak', 'THT', 'Jantung', 'Mata', 'Kandungan', 'Kulit', 'Penyakit Dalam'])->load($api);
        $title = "Chart Ajax";
        return view('chart', compact('chart', 'title'));
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function chartLineAjax(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $dokters = Dokter::select(\DB::raw("COUNT(*) as count"))
                    ->where('bulan', 'LIKE', '%'.$year. '%')
                    ->groupBy(\DB::raw("spesialisasi"))
                    ->pluck('count');
  
        $chart = new DokterLineChart;
  
        $chart->dataset('Dokter Spesialis Chart', 'line', $dokters)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ]);
  
        return $chart->api();
    }

}
