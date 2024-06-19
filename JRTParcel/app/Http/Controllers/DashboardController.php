<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resi; 
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $resi = Resi::latest()->paginate(5);
            $all_resi = Resi::get();

        } else if (Auth::user()->role == 'karyawan') {
            $resi = Resi::where('karyawan_id', Auth::user()->karyawan->id)->latest()->paginate(5);
            $all_resi = Resi::where('karyawan_id', Auth::user()->karyawan->id)->get();
        }

        $karyawanCount = Karyawan::where('bekerja',true)->count();
        $resiCount = Resi::count();

        return view('dashboard', ['karyawan' => $karyawanCount,'resi' => $resi, 'all_resi' => $all_resi, 'resis' => $resiCount]);
    }
}