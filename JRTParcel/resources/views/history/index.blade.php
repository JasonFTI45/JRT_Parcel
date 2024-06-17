<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pengiriman') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card flex flex-row space-x-5 pl-3">
                    <form id="combinedForm" method="GET" action="{{ route('history.index') }}">
                        <div class="flex flex-row space-x-5">
                            <div class="flex flex-row space-y-2">
                                <div class="form-group w-52">
                                    <input type="text" name="search" class="form-control" placeholder="Search by Courier's Name" value="{{ request('search') }}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="action" value="search" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-20 rounded">Search</button>
                                </div>
                            </div>

                            <div class="flex flex-row space-x-2">
                                <div class="flex flex-row space-x-2">
                                    <select class="border-red-400" id="shippingMethod" name="shippingMethod" onchange="updateFilter()">
                                        <option value="">Select shipping method</option>
                                        <option value="water" {{ ($shippingMethod == 'water') ? 'selected' : '' }}>Laut</option>
                                        <option value="air" {{ ($shippingMethod == 'air') ? 'selected' : '' }}>Udara</option>
                                    </select>
                                    <select class="border-red-400" id="shippingLocation" name="shippingLocation" onchange="updateFilter()">
                                        <option value="">Select Shipping Location</option>
                                        @foreach ($karyawan as $k)
                                            <option value="{{ $k->nama }}" {{ ($shippingLocation == $k->nama) ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                    <select class="border-red-400" id="shippingStatus" name="shippingStatus" onchange="updateFilter()">
                                        <option value="">Select shipping Status</option>
                                        <option value="Ruben" {{ ($shippingStatus == 'Ruben') ? 'selected' : '' }}>Collected</option>
                                        <option value="delv" {{ ($shippingStatus == 'delv') ? 'selected' : '' }}>Delivering</option>
                                        <option value="sent" {{ ($shippingStatus == 'sent') ? 'selected' : '' }}>Sent</option>
                                    </select>
                                </div>
                                <div class="form-group self-center">
                                    <button type="submit" name="action" value="filter" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-12 rounded">Filter</button>
                                </div>
                            </div>

                            <div class="flex flex-row space-x-2">
                                <div class="flex flex-row space-x-2">
                                    <select class="border-red-400" id="sortField" name="sortField">
                                        <option value="">Sort by</option>
                                        <option value="id" {{ ($sortField == 'id') ? 'selected' : '' }}>Resi</option>
                                        <option value="nama" {{ ($sortField == 'nama') ? 'selected' : '' }}>Kurir</option>
                                        <option value="pengirim" {{ ($sortField == 'pengirim') ? 'selected' : '' }}>Pengirim</option>
                                        <option value="kota_asal" {{ ($sortField == 'kota_asal') ? 'selected' : '' }}>Kota Asal</option>
                                        <option value="kota_tujuan" {{ ($sortField == 'kota_tujuan') ? 'selected' : '' }}>Kota Tujuan</option>
                                        <option value="penerima" {{ ($sortField == 'penerima') ? 'selected' : '' }}>Penerima</option>
                                    </select>
                                    <select class="border-red-400" id="sortOrder" name="sortOrder">
                                        <option value="asc" {{ ($sortOrder == 'asc') ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ ($sortOrder == 'desc') ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </div>
                                <div class="form-group self-center">
                                    <button type="submit" name="action" value="sort" class="bg-red-500 hover:bg-red-600 active:bg-red-700 w-10 rounded">Sort</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card w-full max-w-full px-4 py-4">
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
                                @foreach ($karyawan as $k)
                                    <tr>
                                        <td>{{ $k->id }}</td>
                                        <td>{{ $k->nama }}<br>{{ $k->nomor_telepon }} </td>
                                        <td class="text-red-500 hover:text-red-700">{{ $k->nama }}<br>{{ $k->nomor_telepon }}</td>
                                        <td >{{ $k->nama }}</td>
                                        <td >{{ $k->nama }}</td>
                                        <td class="text-red-500 hover:text-red-700">{{ $k->nama }}<br>{{ $k->nomor_telepon }}</td>
                                        <td class="text-red-500 hover:text-red-700">{{ $k->nama }}</td>
                                        <td><button class="text-red-500 hover:text-red-700">Print Resi</button></td>
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

<script>
    function updateFilter() {
        var method = document.getElementById('shippingMethod').value;
        var location = document.getElementById('shippingLocation').value;
        var status = document.getElementById('shippingStatus').value;
        document.getElementById('filter').value = method + ',' + location + ',' + status;
    }
</script>
