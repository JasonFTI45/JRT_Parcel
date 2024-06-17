<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Resi;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filter = explode(',', $request->get('filter'));
        $shippingMethod = $filter[0] ?? '';
        $shippingLocation = $filter[1] ?? '';
        $shippingStatus = $filter[2] ?? '';
        $sortField = $request->get('sortField', '');
        $sortOrder = $request->get('sortOrder', '');
        $resi = Resi::query();

        if ($search) {
            $resi->whereHas('karyawan', function ($query) use ($search) {
                $query->whereRaw('LOWER(nama) LIKE ?', [strtolower("%{$search}%")]);
            });
        }

        if ($shippingMethod) {
            $resi->where('jenisPengiriman', $shippingMethod);
        }
        // if ($shippingLocation) {
        //     $resi->where('shipping_location', $shippingLocation);
        // }
        // if ($shippingStatus) {
        //     $resi->where('id', $shippingStatus);
        // }

        // if ($sortField && $sortOrder) {
        //     $resi->orderBy($sortField, $sortOrder);
        // }

        $resi = $resi->get();

        return view('history.index', compact('shippingMethod', 'shippingLocation', 'shippingStatus', 'sortField', 'sortOrder', 'resi'));
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
