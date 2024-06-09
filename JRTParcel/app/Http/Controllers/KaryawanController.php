<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    //
    public function index()
    {
        $karyawan = Karyawan::all();

        return view('karyawan.index',compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function edit($email)
    {
        $karyawan = Karyawan::where('email', $email)->first();

        if (!$karyawan) {
            // Handle the case where no karyawan with the given email exists
            return redirect()->route('karyawan.index')->with('error', 'No karyawan found with the given email');
        }

        return view('karyawan.edit', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required',
        ]);

        $karyawan = Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success','Karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, $email)
    {
        $request->validate([
            'nama' => 'required',
            'nomor_telepon' => 'required',
        ]);

        $update = [
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
        ];

        Karyawan::where('email', $email)->update($update);

        return redirect()->route('karyawan.index');
    }

    public function destroy($karyawan)
    {
        $karyawan = Karyawan::where('email', $karyawan)->first();
        $karyawan->delete();

        return redirect()->route('karyawan.index');
    }

}
