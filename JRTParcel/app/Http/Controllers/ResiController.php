<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resi;
use App\Models\Penerima;
use App\Models\Pengirim;
use App\Models\Barang;

class ResiController extends Controller
{
    public function index(){
        $resis = Resi::with('penerima', 'pengirim')->get();
        return view('resi.index', compact('resis'));
    }

    public function create(){
        return view('resi.create');
    }

    public function details(Resi $resi){
        // dd($resi);
        return view('resi.details', compact('resi'));
    }

    public function edit(Resi $resi){
        return view('resi.edit', compact('resi'));
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'penerima_nama' => 'required|string',
            'penerima_nomorTelepon' => 'required|string',
            'penerima_alamat' => 'required|string',
            'pengirim_nama' => 'required|string',
            'pengirim_nomorTelepon' => 'required|string',
            'pengirim_alamat' => 'required|string',
            'jenisPengiriman' => 'required|string|in:Udara,Laut',
            'kecamatan_kota_tujuan' => 'required|string',
            'kecamatan_kota_asal' => 'required|string',
            'barang.*.tipe_komoditas' => 'required|string',
            'barang.*.lebar' => 'required|integer',
            'barang.*.panjang' => 'required|integer',
            'barang.*.tinggi' => 'required|integer',
        ]);

        // Create penerima
        $penerima = Penerima::create([
            'namaPenerima' => $request->input('penerima_nama'),
            'nomorTelepon' => $request->input('penerima_nomorTelepon'),
            'alamat' => $request->input('penerima_alamat'),
        ]);

        // Create Pengirim
        $pengirim = Pengirim::create([
            'namaPengirim' => $request->input('pengirim_nama'),
            'nomorTelepon' => $request->input('pengirim_nomorTelepon'),
            'alamat' => $request->input('pengirim_alamat'),
        ]);

        // Create Resi
        $resi = Resi::create([
            'jenisPengiriman' => $request->input('jenisPengiriman'),
            'kecamatan_kota_tujuan' => $request->input('kecamatan_kota_tujuan'),
            'kecamatan_kota_asal' => $request->input('kecamatan_kota_asal'),
            'penerima_id' => $penerima ? $penerima->id : null,
            'pengirim_id' => $pengirim ? $pengirim->id : null,
            'created_at' => now(),
        ]);

        // Create Barang
        foreach ($request->input('barang') as $barangData) {
            Barang::create([
                'resi_id' => $resi->id,
                'tipe_komoditas' => $barangData['tipe_komoditas'],
                'berat' => $barangData['berat'],
                'lebar' => $barangData['lebar'],
                'panjang' => $barangData['panjang'],
                'tinggi' => $barangData['tinggi'],
                'created_at' => now(),
            ]);
        }

        return redirect()->route('resi.create')->with('success', 'Resi created successfully');
    }

    
}
