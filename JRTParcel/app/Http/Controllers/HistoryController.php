<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

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

        $karyawan = Karyawan::query();

        if ($search) {
            $karyawan->whereRaw('LOWER(nama) LIKE ?', [strtolower("%{$search}%")]);
        }

        if ($shippingMethod) {
            $karyawan->where('shipping_method', $shippingMethod);
        }
        if ($shippingLocation) {
            $karyawan->where('shipping_location', $shippingLocation);
        }
        if ($shippingStatus) {
            $karyawan->where('id', $shippingStatus);
        }

        if ($sortField && $sortOrder) {
            $karyawan->orderBy($sortField, $sortOrder);
        }

        $karyawan = $karyawan->get();

        return view('history.index', compact('shippingMethod', 'shippingLocation', 'shippingStatus', 'sortField', 'sortOrder', 'karyawan'));
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
