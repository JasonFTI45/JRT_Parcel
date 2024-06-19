<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Kode Resi</th>
                            <th class="py-3 px-6 text-left">Jenis Pengiriman</th>
                            <th class="py-3 px-6 text-left">Penerima</th>
                            <th class="py-3 px-6 text-left">Pengirim</th>
                            <th class="py-3 px-6 text-left">Kecamatan/Kota Asal</th>
                            <th class="py-3 px-6 text-left">Kecamatan/Kota Tujuan</th>
                            <th class="py-3 px-6 text-left">Actions</th>
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
                                    <a href="{{ route('resi.details', $resi->id) }}" class="text-blue-500 hover:text-blue-700">Details</a>
                                    <a href="{{ route('resi.edit', $resi->id) }}" class="ml-2 text-blue-500 hover:text-blue-700">Edit</a>
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
                        {{ __('Add Resi') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
