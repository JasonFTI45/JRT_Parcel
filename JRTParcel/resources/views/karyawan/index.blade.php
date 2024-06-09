<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>Karyawan Table</h2>
                    <table>
                        <tr>
                            <th>nama</th>
                            <th>nomor_telepon</th>
                            <th>email</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($karyawan as $kry)
                            <tr>
                                <td>{{ $kry['nama'] }}</td>
                                <td>{{ $kry['nomor_telepon'] }}</td>
                                <td>{{ $kry['email'] }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <a href="{{ route('karyawan.edit', $kry->email) }}" class="edit button">Edit</a>
                                        <form action="{{ route('karyawan.destroy', $kry->email) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete button">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <a href="{{ route('karyawan.create') }}" class="add button">Tambah Karyawan</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

