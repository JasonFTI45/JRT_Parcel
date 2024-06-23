<x-app-layout>

    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border-solid ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-center font-bold text-2xl mb-5">DAFTAR PAKET</h1>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">No. Resi</th>
                            <th class="py-3 px-6 text-left">Jenis Pengiriman</th>
                            <th class="py-3 px-6 text-left">Penerima</th>
                            <th class="py-3 px-6 text-left">Pengirim</th>
                            <th class="py-3 px-6 text-left">Kecamatan/Kota Asal</th>
                            <th class="py-3 px-6 text-left">Kecamatan/Kota Tujuan</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    @foreach($resis as $resi)
                        @if($resi->karyawan->id == auth()->user()->karyawan->id)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $resi->kodeResi }}</td>
                                <td class="py-3 px-6 text-left">{{ $resi->jenisPengiriman }}</td>
                                <td class="py-3 px-6 text-left">{{ $resi->penerima->namaPenerima }}</td>
                                <td class="py-3 px-6 text-left">{{ $resi->pengirim->namaPengirim }}</td>
                                <td class="py-3 px-6 text-left">{{ $resi->kecamatan_kota_asal }}</td>
                                <td class="py-3 px-6 text-left">{{ $resi->kecamatan_kota_tujuan }}</td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex">
                                        <a href="{{ route('resi.details', $resi->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Details</a>
                                        <a href="{{ route('resi.edit', $resi->id) }}" class="ml-2 bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                        <a href="{{ route('resi.print', $resi->id) }}" target="_blank" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Print</a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $resis->links() }}
                <div class="flex justify-between items-start">
                    <div class="flex-grow">
                        <table class="min-w-full leading-normal">
                            <!-- Your table content here -->
                        </table>
                    </div>
                    <a href="{{ route('resi.create') }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        {{ __('Tambah Paket') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
