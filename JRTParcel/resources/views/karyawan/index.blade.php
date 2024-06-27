<x-app-layout>

    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-center font-bold text-2xl mb-2">DAFTAR KARYAWAN</h1>
                <div class="p-6 text-gray-900">
                    <div class="overflow-y-auto max-h-500">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Nomor Telepon</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($karyawan as $kry)
                                @if ($kry->bekerja)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $kry['nama'] }}</td>
                                    <td class="py-3 px-6 text-left">{{ $kry['nomor_telepon'] }}</td>
                                    <td class="py-3 px-6 text-left">{{ $kry['email'] }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex">
                                            <a href="{{ route('karyawan.edit', $kry->email) }}" class="edit button">Edit</a>
                                            <form action="{{ route('karyawan.destroy', $kry->email) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete button" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between items-start">
                        <div class="flex-grow">
                            <table class="min-w-full leading-normal">
                                <!-- Your table content here -->
                            </table>
                        </div>
                        <a href="{{ route('karyawan.create') }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Tambah Karyawan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>