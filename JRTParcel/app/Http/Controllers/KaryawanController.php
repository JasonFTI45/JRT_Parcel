<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            return redirect()->route('karyawan.index')->with('error', 'No karyawan found with the given email');
        }

        return view('karyawan.edit', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required', 
        ]);

        try {
            $karyawan = Karyawan::create($request->all());

            // Create a new user for the karyawan
            $user = new User;
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'karyawan';
            $user->karyawan_id = $karyawan->id; 
            $user->save();

            return redirect()->route('karyawan.index')->with('success','Karyawan berhasil ditambahkan!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['email' => 'Email already exists.']);
        }
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

        // Set the bekerja field to false
        $karyawan->bekerja = false;
        $karyawan->save();

        // Set the isEnabled field of the associated user to false
        if ($karyawan->user) {
            $karyawan->user->isEnabled = false;
            $karyawan->user->save();
        }

        return redirect()->route('karyawan.index');
    }

}
