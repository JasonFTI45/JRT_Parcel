<!-- HALAMAN UNTUK EDIT KARYAWAN KETIKA LOGIN SEBAGAI ADMIN -->
<!-- ADMIN HANYA DAPAT MEMPERBARUI NAMA DAN NOMOR TELEPON KARYAWAN -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('karyawan.update', $karyawan->email) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="form-label" for="nama">Nama:</label>
                            <input class="form-input" type="text" name="nama" id="nama" value="{{ $karyawan->nama }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="nomor_telepon">Nomor Telepon:</label>
                            <input class="form-input" type="number" name="nomor_telepon" id="nomor_telepon" value="{{ $karyawan->nomor_telepon }}" required>
                        </div>

                        <div>
                            <button type="submit" class="update button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>