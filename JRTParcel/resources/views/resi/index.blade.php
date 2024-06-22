<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex">
                <form class="w-full"id="combinedForm" method="GET" action="{{ route('resi.index') }}">
                    <div class="flex justify-between">
                        <div class="flex space-y-2">
                            <div class="form-group w-52">
                                <input type="text" name="search" class="form-control" placeholder="Search by Penerima's Name" value="{{ request('search') }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="action" value="search" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-20 rounded">Search</button>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-2">
                            <div class="flex flex-row space-x-2">
                                <select class="border-red-400" id="shippingMethod" name="shippingMethod">
                                    <option value="">Select Shipping method</option>
                                    <option value="Laut" {{ ($shippingMethod == 'Laut') ? 'selected' : '' }}>Laut</option>
                                    <option value="Udara" {{ ($shippingMethod == 'Udara') ? 'selected' : '' }}>Udara</option>
                                </select>
                                <select class="border-red-400 max-w-64 " id="shippingLocation" name="shippingLocation" >
                                    <option value="">Select Shipping Location</option>
                                    @foreach ($lokasi as $lokasi)
                                        <option   value="{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}" {{ ($shippingLocation == ($lokasi->kecamatan . ', ' . $lokasi->kota)) ? 'selected' : '' }}>{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}</option>
                                    @endforeach
                                </select>
                                <select class="border-red-400" id="shippingStatus" name="shippingStatus">
                                    <option value="">Select Shipping Status</option>
                                    <option value="Menunggu Pengiriman" {{ ($shippingStatus == 'Menunggu Pengiriman') ? 'selected' : '' }}>Menunggu Pengiriman</option>
                                    <option value="Sedang Dikirim" {{ ($shippingStatus == 'Sedang Dikirim') ? 'selected' : '' }}>Sedang Dikirim</option>
                                    <option value="Sudah Sampai" {{ ($shippingStatus == 'Sudah Sampai') ? 'selected' : '' }}>Sudah Sampai</option>
                                </select>
                                <div class="form-group self-center">
                                    <button type="submit" name="action" value="filter" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-12 rounded">Filter</button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-2">
                            <div class="flex flex-row space-x-2">
                                <select class="border-red-400" id="sortField" name="sortField">
                                    <option value="">Sort by</option>
                                    <option value="id" {{ ($sortField == 'id') ? 'selected' : '' }}>Resi ID</option>
                                    <option value="kecamatan_kota_asal" {{ ($sortField == 'kecamatan_kota_asal') ? 'selected' : '' }}>Kota Asal</option>
                                    <option value="kecamatan_kota_tujuan" {{ ($sortField == 'kecamatan_kota_tujuan') ? 'selected' : '' }}>Kota Tujuan</option>
                                </select>
                                <select class="border-red-400" id="sortOrder" name="sortOrder">
                                    <option value="asc" {{ ($sortOrder == 'asc') ? 'selected' : '' }}>Ascending</option>
                                    <option value="desc" {{ ($sortOrder == 'desc') ? 'selected' : '' }}>Descending</option>
                                </select>
                                <div class="form-group self-center">
                                    <button type="submit" name="action" value="sort" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-10 rounded">Sort</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
                        {{ __('Add Resi') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
