<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resi;
use App\Models\Penerima;
use App\Models\Pengirim;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class ResiController extends Controller
{
    public function index(){
        $resis = Resi::with('penerima', 'pengirim')->where('karyawan_id', auth()->user()->karyawan->id)->paginate(10);
        return view('resi.index', compact('resis'));
    }

    public function create(){
        return view('resi.create');
    }

    public function details(Resi $resi){
        $resi->load('barangs');
        return view('resi.details', compact('resi'));
    }

    public function generatePdf(Resi $resi){
        $resi->load('barangs');
        $data = [
            'title' => 'JRT Parcel',
            'date' => $resi->created_at,
            'resi' => $resi,
        ];

        $pdf = Pdf::loadView('resi.print', $resi);
        return $pdf->stream('invoice.pdf');
    }

    public function edit(Resi $resi){
        $resi->load('barangs');
        return view('resi.edit', compact('resi'));
    }

    public function update(Resi $resi, Request $request){
        // Validate request
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
            'barang.*.berat' => 'required|numeric',
            'barang.*.lebar' => 'required|numeric',
            'barang.*.panjang' => 'required|numeric',
            'barang.*.tinggi' => 'required|numeric',
        ]);
    
        // Check and update Penerima
        $penerima = Penerima::firstOrCreate(
            [
                'namaPenerima' => $request->input('penerima_nama'),
                'nomorTelepon' => $request->input('penerima_nomorTelepon'),
            ],
            [
                'alamat' => $request->input('penerima_alamat'),
            ]
        );
    
        // Check and update Pengirim
        $pengirim = Pengirim::firstOrCreate(
            [
                'namaPengirim' => $request->input('pengirim_nama'),
                'nomorTelepon' => $request->input('pengirim_nomorTelepon'),
            ],
            [
                'alamat' => $request->input('pengirim_alamat'),
            ]
        );
    
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang');
    
        // Recalculate harga
        $harga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
    
        // Update Resi
        $resi->update([
            'jenisPengiriman' => $request->input('jenisPengiriman'),
            'kecamatan_kota_tujuan' => $request->input('kecamatan_kota_tujuan'),
            'kecamatan_kota_asal' => $request->input('kecamatan_kota_asal'),
            'penerima_id' => $penerima->id,
            'pengirim_id' => $pengirim->id,
            'harga' => $harga,
            'status' => 'Updated Status', // Update status as needed
        ]);
    
        // Update Barang
        $existingBarangs = $resi->barangs->keyBy('id');
        foreach ($barangData as $data) {
            if (isset($data['id'])) {
                // Update existing Barang
                $existingBarangs[$data['id']]->update([
                    'tipe_komoditas' => $data['tipe_komoditas'],
                    'berat' => $data['berat'],
                    'lebar' => $data['lebar'],
                    'panjang' => $data['panjang'],
                    'tinggi' => $data['tinggi'],
                ]);
                // Remove updated barang from the list
                $existingBarangs->forget($data['id']);
            } else {
                // Create new Barang
                Barang::create([
                    'resi_id' => $resi->id,
                    'tipe_komoditas' => $data['tipe_komoditas'],
                    'berat' => $data['berat'],
                    'lebar' => $data['lebar'],
                    'panjang' => $data['panjang'],
                    'tinggi' => $data['tinggi'],
                    'created_at' => now(),
                ]);
            }
        }
    
        // Delete Barangs that were not included in the request
        foreach ($existingBarangs as $barang) {
            $barang->delete();
        }
    
        return redirect()->route('resi.edit', $resi)->with('success', 'Resi updated successfully');
    }
    
    public function store(Request $request){
        // Validate request
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
            'barang.*.berat' => 'required|numeric',
            'barang.*.lebar' => 'required|numeric',
            'barang.*.panjang' => 'required|numeric',
            'barang.*.tinggi' => 'required|numeric',
        ]);
    
        // Check and create Penerima if not exists
        $penerima = Penerima::firstOrCreate(
            [
                'namaPenerima' => $request->input('penerima_nama'),
                'nomorTelepon' => $request->input('penerima_nomorTelepon'),
            ],
            [
                'alamat' => $request->input('penerima_alamat'),
            ]
        );
    
        // Check and create Pengirim if not exists
        $pengirim = Pengirim::firstOrCreate(
            [
                'namaPengirim' => $request->input('pengirim_nama'),
                'nomorTelepon' => $request->input('pengirim_nomorTelepon'),
            ],
            [
                'alamat' => $request->input('pengirim_alamat'),
            ]
        );
    
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
        foreach ($barangData as $barang) {
            Barang::create([
                'resi_id' => $resi->id,
                'tipe_komoditas' => $barang['tipe_komoditas'],
                'berat' => $barang['berat'],
                'lebar' => $barang['lebar'],
                'panjang' => $barang['panjang'],
                'tinggi' => $barang['tinggi'],
                'created_at' => now(),
            ]);
        }
    
        return redirect()->route('resi.create')->with('success', 'Resi created successfully');
    }
    

    // to show harga in resi.create
    public function calculateHargaAjax(Request $request)
    {
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang');
        $harga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
    
        return response()->json(['harga' => $harga]);
    }
    
    // to calculate harga in resi.create
    function calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData) {
        $udaraGeneralPerKg = 35000;
        $udaraGeneralPerHalfKg = 20000;
    
        $udaraPnkPerKg = 30000;
        $udaraPnkPerHalfKg = 15000;
    
        $lautPerKg = 10000;
        $lautMinimal = 20000;

        $volumetrikUdara = 6000;
        $volumetrikLaut = 4000;
    
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
                $volume = $barang['panjang'] * $barang['lebar'] * $barang['tinggi'];
                $beratVolume = $volume/$volumetrikUdara;

                if($beratVolume > $berat1Paket){
                    $berat1Paket = $beratVolume;
                }
    
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
                $volume = $barang['panjang'] * $barang['lebar'] * $barang['tinggi'];
                $beratVolume = $volume/$volumetrikLaut;

                if($beratVolume > $berat1Paket){
                    $berat1Paket = $beratVolume;
                }
    
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
