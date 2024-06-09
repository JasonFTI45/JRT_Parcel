<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('karyawan.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="nama">Nama:</label>
                            <input class="form-input" type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="alamat">Nomor Telepon:</label>
                            <input class="form-input" type="number"  name="nomor_telepon" id="nomor_telepon" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="telepon">email:</label>
                            <input class="form-input" type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <button type="submit" class="add button">Submit</button>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>