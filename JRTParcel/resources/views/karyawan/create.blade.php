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
                            <label class="form-label" for="nomor_telepon">Nomor Telepon:</label>
                            <input class="form-input" type="number"  name="nomor_telepon" id="nomor_telepon" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">email:</label>
                            <input class="form-input" type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">password:</label>
                            <input class="form-input" type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="add button mb-4 ">Submit</button>
                    </form>
                    
                    @if ($errors->any())
                            <div class="">
                                <x-input-error :messages="$errors" />
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>