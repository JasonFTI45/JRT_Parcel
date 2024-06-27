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
            $totalResiCount = Resi::count();
        } else if (Auth::user()->role == 'karyawan') {
            $resi = Resi::where('karyawan_id', Auth::user()->karyawan->id)->latest()->paginate(5);
            $all_resi = Resi::where('karyawan_id', Auth::user()->karyawan->id)->get();
            $totalResiCount = Resi::where('karyawan_id', Auth::user()->karyawan->id)->count();
        }

        $karyawanCount = Karyawan::where('bekerja',true)->count();
        
        

        return view('dashboard', ['karyawanCount' => $karyawanCount,'resi' => $resi, 'all_resi' => $all_resi, 'totalResi' => $totalResiCount]);
    }
}