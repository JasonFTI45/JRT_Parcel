<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resi;
use App\Models\Penerima;
use App\Models\Pengirim;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Lokasi;

class ResiController extends Controller
{
    public function index(Request $request) { // Inject Request $request here
        $search = $request->get('search');
        $shippingMethod = $request->get('shippingMethod');
        $shippingLocation = $request->get('shippingLocation');
        $shippingStatus = $request->get('shippingStatus');
        $sortField = $request->get('sortField', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');
        $resi = Resi::query();

        if ($search) {
            $resi->whereHas('penerima', function ($query) use ($search) {
                $query->whereRaw('LOWER("namaPenerima") LIKE ?', [strtolower("%{$search}%")]);
            });
        }

        if ($shippingMethod) {
            $resi->where('jenisPengiriman', $shippingMethod);
        }
        if ($shippingLocation) {
            $resi->where('kecamatan_kota_tujuan', $shippingLocation);
        }
        if ($shippingStatus) {
            $resi->where('status', $shippingStatus);
        }

        if ($sortField === 'nama') {
            $resi->join('karyawan', 'resi.karyawan_id', '=', 'karyawan.id')
                ->orderBy('karyawan.nama', $sortOrder)
                ->select('resi.*');
        } else {
            $resi->orderBy($sortField, $sortOrder);
        }

        // Apply the filters and sorting to the final query
        $resis = $resi->with('penerima', 'pengirim')->where('karyawan_id', auth()->user()->karyawan->id)->paginate(10)->appends([
                    'search' => $request->get('search'),
                    'shippingMethod' => $request->get('shippingMethod'),
                    'shippingLocation' => $request->get('shippingLocation'),
                    'shippingStatus' => $request->get('shippingStatus'),
                    'sortField' => $request->get('sortField', 'id'),
                    'sortOrder' => $request->get('sortOrder', 'asc'),
                ]);
        $lokasi = Lokasi::get();

        return view('resi.index', compact('resis','shippingMethod', 'shippingLocation', 'shippingStatus', 'lokasi', 'sortField', 'sortOrder'));
}

    public function create(){

        $lokasi = Lokasi::all();
        return view('resi.create', compact('lokasi'));
    }

    public function details(Resi $resi){
        $resi->load('barangs');
        return view('resi.details', compact('resi'));
    }

    public function generatePdf(Resi $resi){
        $resi->load('barangs');
        return view('resi.print', compact('resi'));
    }

    public function edit(Resi $resi){
        $resi->load('barangs');
        $lokasi = Lokasi::all();
        return view('resi.edit', compact('resi', 'lokasi'));
    }

    // to find or create penerima in resi.create
    private function findOrCreatePenerima($request)
    {
        $penerima = Penerima::where('namaPenerima', $request->input('penerima_nama'))
                            ->where('nomorTelepon', $request->input('penerima_nomorTelepon'))
                            ->first();

        if (!$penerima) {
            $penerima = Penerima::create([
                'namaPenerima' => $request->input('penerima_nama'),
                'nomorTelepon' => $request->input('penerima_nomorTelepon'),
                'alamat' => $request->input('penerima_alamat'),
            ]);
        } else {
            $penerima->update(['alamat' => $request->input('penerima_alamat')]);
        }

        return $penerima;
    }

    // to find or create pengirim in resi.create
    private function findOrCreatePengirim($request)
    {
        $pengirim = Pengirim::where('namaPengirim', $request->input('pengirim_nama'))
                            ->where('nomorTelepon', $request->input('pengirim_nomorTelepon'))
                            ->first();

        if (!$pengirim) {
            $pengirim = Pengirim::create([
                'namaPengirim' => $request->input('pengirim_nama'),
                'nomorTelepon' => $request->input('pengirim_nomorTelepon'),
                'alamat' => $request->input('pengirim_alamat'),
            ]);
        } else {
            $pengirim->update(['alamat' => $request->input('pengirim_alamat')]);
        }

        return $pengirim;
    }

    private function checkKecamatanKota($kecamatanKotaTujuan)
    {
        if (!$kecamatanKotaTujuan) {
            return null;
        }
        if(strpos($kecamatanKotaTujuan, ', ') === false){
            return null;
        }
        
        list($kecamatan, $kota) = explode(', ', $kecamatanKotaTujuan);
        $exists = Lokasi::where('kecamatan', $kecamatan)
            ->where('kota', $kota)
            ->exists();
        if (!$exists) {
            return null;
        }
        
        return null;
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
            'metodePembayaran' => 'required|string',
            'statusPembayaran' => 'required|string',
            'status' => 'required|string',
        ]);       
    
        // Save Penerima and Pengirim
        $penerima = $this->findOrCreatePenerima($request);
        $pengirim = $this->findOrCreatePengirim($request);
    
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang');

        //check for kecamatan kota
        if($this->checkKecamatanKota($kecamatanKotaTujuan) == null){
            return redirect()->route('resi.create')->with('kecamatan_kota_tujuan_error', 'Please select one of the option');
        }

        // Recalculate harga
        $totalHarga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
        // Update Resi
        $resi->update([
            'jenisPengiriman' => $request->input('jenisPengiriman'),
            'kecamatan_kota_tujuan' => $request->input('kecamatan_kota_tujuan'),
            'kecamatan_kota_asal' => $request->input('kecamatan_kota_asal'),
            'penerima_id' => $penerima->id,
            'pengirim_id' => $pengirim->id,
            'harga' => $totalHarga,
            'metodePembayaran' => $request->input('metodePembayaran'),
            'statusPembayaran' => $request->input('statusPembayaran'),
            'status' => $request->input('status'),
        ]);
    
        // Update Barang
        $existingBarangs = $resi->barangs->keyBy('id');
        foreach ($barangData as $data) {
            if (isset($data['id'])) {
                // Update existing Barang
                $existingBarangs[$data['id']]->update([
                    'tipe_komoditas' => $data['tipe_komoditas'],
                    'berat' => $data['berat'],
                    'beratVolume' => $this->calculateBeratVolumetrik($data['panjang'], $data['lebar'], $data['tinggi'], $jenisPengiriman),
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
                    'beratVolume' => $this->calculateBeratVolumetrik($data['panjang'], $data['lebar'], $data['tinggi'], $jenisPengiriman),
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
            'metodePembayaran' => 'required|string',
            'statusPembayaran' => 'required|string',
        ]);
    
        // Save Penerima and Pengirim
        $penerima = $this->findOrCreatePenerima($request);
        $pengirim = $this->findOrCreatePengirim($request);
    
        $karyawan_id = Auth::user()->karyawan->id;
        $kecamatanKotaTujuan = $request->input('kecamatan_kota_tujuan');
        $jenisPengiriman = $request->input('jenisPengiriman');
        $barangData = $request->input('barang'); // Ensure 'barang' is structured correctly in your request

        //check for kecamatan kota in database
        if($this->checkKecamatanKota($kecamatanKotaTujuan) == null){
            return redirect()->route('resi.create')->with('kecamatan_kota_tujuan_error', 'Please select one of the option');
        }

        // Adjusted method call
        $totalHarga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
        // Create Resi
        $resi = Resi::create([
            'jenisPengiriman' => $request->input('jenisPengiriman'),
            'kecamatan_kota_tujuan' => $request->input('kecamatan_kota_tujuan'),
            'kecamatan_kota_asal' => $request->input('kecamatan_kota_asal'),
            'penerima_id' => $penerima ? $penerima->id : null,
            'pengirim_id' => $pengirim ? $pengirim->id : null,
            'harga' => $totalHarga,
            'metodePembayaran'=> $request->input('metodePembayaran'),
            'statusPembayaran'=> $request->input('statusPembayaran'),
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
                'beratVolume' => $this->calculateBeratVolumetrik($barang['panjang'], $barang['lebar'], $barang['tinggi'], $jenisPengiriman),
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
        $totalHarga = $this->calculateHarga($kecamatanKotaTujuan, $jenisPengiriman, $barangData);
    
        return response()->json(['harga' => $totalHarga]);
    }
    
    private function calculateBeratVolumetrik($panjang, $lebar, $tinggi, $jenisPengiriman){
        $volumetrikUdara = 6000;
        $volumetrikLaut = 4000;

        $volume = $panjang * $lebar * $tinggi;

        if($jenisPengiriman == 'Udara'){
            $beratVolume = $volume/$volumetrikUdara;
            if ($beratVolume == 0){
                $beratVolume = 0;
            } else if ($beratVolume < 1) {
                $beratVolume = 1;
            } else if ($beratVolume <= 1.5) {
                $beratVolume = 1.5;
            } else {
                $beratVolume = ceil($beratVolume);
            }

            return $beratVolume;

        } else if($jenisPengiriman == 'Laut'){
            $beratVolume = $volume/$volumetrikLaut;
            if ($beratVolume == 0){
                $beratVolume = 0;
            } else if ($beratVolume <= 2) {
                $beratVolume = 2;
            } else {
                $beratVolume = ceil($beratVolume);
            }

            return $beratVolume;
        }
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
                if ($berat1Paket == 0){
                    $berat1Paket = 0;
                } else if ($berat1Paket < 0.5) {
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
                if ($berat1Paket == 0){
                    $berat1Paket = 0;
                } else if ($berat1Paket <= 1) {
                    $berat1Paket = 1;
                } else {
                    $berat1Paket = ceil($berat1Paket);
                }
    
                // Calculate price for each package
                if ($berat1Paket > 0 && $berat1Paket <= 2) {
                    $totalHarga += $lautMinimal;
                } else {
                    $totalHarga += $lautMinimal + ($berat1Paket - 2) * $lautPerKg;
                }
            }
    
            return $totalHarga;
        }
    }
    
}
