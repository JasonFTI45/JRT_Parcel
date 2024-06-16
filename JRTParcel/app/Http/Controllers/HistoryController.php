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

        $karyawan = Karyawan::query();

        if ($search) {
            $karyawan->whereRaw('LOWER(nama) LIKE ?', [strtolower("%{$search}%")]);
        }

        $karyawan = $karyawan->get();

        return view('history.index', compact('shippingMethod', 'shippingLocation', 'shippingStatus', 'karyawan'));
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

}