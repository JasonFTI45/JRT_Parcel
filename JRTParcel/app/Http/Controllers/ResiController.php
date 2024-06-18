<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $karyawan_id = Auth::user()->karyawan->id;
        
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang'); // Ensure 'barang' is structured correctly in your request

        // Adjusted method call
        $harga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
        // Create Resi
        $resi = Resi::create([
            'jenisPengiriman' => $request->input('jenisPengiriman'),
            'kecamatan_kota_tujuan' => $request->input('kecamatan_kota_tujuan'),
            'kecamatan_kota_asal' => $request->input('kecamatan_kota_asal'),
            'penerima_id' => $penerima ? $penerima->id : null,
            'pengirim_id' => $pengirim ? $pengirim->id : null,
            'harga' => $harga,
            'karyawan_id' => $karyawan_id, 
            'created_at' => now(),
            'status' => 'Menunggu Pengiriman',
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

    public function calculateHargaAjax(Request $request)
    {
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang');
        $harga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
    
        return response()->json(['harga' => $harga]);
    }
    
    function calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData) {
        $udaraGeneralPerKg = 35000;
        $udaraGeneralPerHalfKg = 20000;
    
        $udaraPnkPerKg = 30000;
        $udaraPnkPerHalfKg = 15000;
    
        $lautPerKg = 10000;
        $lautMinimal = 20000;
    
        if ($jenisPengiriman == 'Udara') {
            if ($kecamatanKotaTujuan && strpos($kecamatanKotaTujuan, 'PONTIANAK') !== false) {
                $biayaPerKg = $udaraPnkPerKg;
                $biayaPerHalfKg = $udaraPnkPerHalfKg;
            } else {
                $biayaPerKg = $udaraGeneralPerKg;
                $biayaPerHalfKg = $udaraGeneralPerHalfKg;
            }
    
            $totalHarga = 0;
    
            foreach ($barangData as $barang) {
                $berat1Paket = $barang['berat'];
    
                // Pembulatan berat
                if ($berat1Paket < 0.5) {
                    $berat1Paket = 0.5;
                } else if ($berat1Paket <= 1) {
                    $berat1Paket = 1;
                } else if ($berat1Paket <= 1.5) {
                    $berat1Paket = 1.5;
                } else {
                    $berat1Paket = ceil($berat1Paket);
                }
    
                // Calculate price for each package
                while ($berat1Paket > 0) {
                    if ($berat1Paket >= 1) {
                        $totalHarga += $biayaPerKg;
                        $berat1Paket -= 1;
                    } else {
                        $totalHarga += $biayaPerHalfKg;
                        $berat1Paket -= 0.5;
                    }
                }
            }
    
            return $totalHarga; 
        } else {
            $totalHarga = 0;
    
            foreach ($barangData as $barang) {
                $berat1Paket = $barang['berat'];
    
                // Pembulatan berat
                if ($berat1Paket <= 1) {
                    $berat1Paket = 1;
                } else {
                    $berat1Paket = ceil($berat1Paket);
                }
    
                // Calculate price for each package
                if ($berat1Paket <= 2) {
                    $totalHarga += $lautMinimal;
                } else {
                    $totalHarga += $lautMinimal + ($berat1Paket - 2) * $lautPerKg;
                }
            }
    
            return $totalHarga;
        }
    }
    
}
