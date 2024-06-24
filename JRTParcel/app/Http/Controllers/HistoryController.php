<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Resi;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $shippingMethod = $request->get('shippingMethod');
        $shippingLocation = $request->get('shippingLocation');
        $shippingStatus = $request->get('shippingStatus');
        $sortField = $request->get('sortField', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');
        $resi = Resi::query();

        if ($search) {
            $resi->whereHas('karyawan', function ($query) use ($search) {
                $query->whereRaw('LOWER(nama) LIKE ?', [strtolower("%{$search}%")]);
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

        $resi = $resi->paginate(10)->appends([
                    'search' => $request->get('search'),
                    'shippingMethod' => $request->get('shippingMethod'),
                    'shippingLocation' => $request->get('shippingLocation'),
                    'shippingStatus' => $request->get('shippingStatus'),
                    'sortField' => $request->get('sortField', 'id'),
                    'sortOrder' => $request->get('sortOrder', 'asc'),
                ]);
        $lokasi = Lokasi::get();

        return view('history.index', compact('shippingMethod', 'shippingLocation', 'shippingStatus', 'sortField', 'sortOrder', 'resi', 'lokasi'));
    }

    public function print(Resi $resi){
        $resi->load('barangs');
        return view('history.print', compact('resi'));
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
