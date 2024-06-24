<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="flex">
                    <form class="w-full" id="combinedForm" method="GET" action="{{ route('history.index') }}">
                        <div class="flex justify-between">
                            <div class="flex space-y-2">
                                <div class="form-group w-52">
                                    <input type="text" name="search" class="form-control" placeholder="Search by Name" value="{{ request('search') }}">
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
                                    <select class="border-red-400 max-w-64 " id="shippingLocation" name="shippingLocation">
                                        <option value="">Select Shipping Location</option>
                                        @foreach ($lokasi as $lokasi)
                                        <option value="{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}" {{ ($shippingLocation == ($lokasi->kecamatan . ', ' . $lokasi->kota)) ? 'selected' : '' }}>{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}</option>
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
                                        <option value="id" {{ ($sortField == 'id') ? 'selected' : '' }}>No. Resi</option>
                                        <option value="nama" {{ ($sortField == 'nama') ? 'selected' : '' }}>Kurir</option>
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
                <div class="card w-full max-w-full py-4">
                    <div class="card-body overflow-y-auto max-h-500">
                        <table class="table px-4">
                            <thead>
                                <tr>
                                    <th>Resi</th>
                                    <th>Kurir</th>
                                    <th>Pengirim</th>
                                    <th>Kota Asal</th>
                                    <th>Kota Tujuan</th>
                                    <th>Penerima</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resi as $r)
                                <tr>
                                    <td>{{ $r->kodeResi }}</td>
                                    <td>{{ $r->karyawan->nama}}<br>{{ $r->karyawan->nomor_telepon}}</td>
                                    <td class="text-red-500 hover:text-red-700">{{ $r->pengirim->namaPengirim }}<br>{{ $r->pengirim->nomorTelepon }}</td>
                                    <td>{{ $r->kecamatan_kota_asal }}</td>
                                    <td>{{ $r->kecamatan_kota_tujuan }}</td>
                                    <td class="text-red-500 hover:text-red-700">{{ $r->penerima->namaPenerima }}<br>{{ $r->penerima->nomorTelepon }}</td>
                                    <td class="text-red-500 hover:text-red-700">{{ $r->status }}</td>
                                    <td><a href="{{ route('history.print', $r->id) }}" target="_blank" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Print</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>