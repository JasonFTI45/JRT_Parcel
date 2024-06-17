<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pengiriman') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card flex flex-row space-x-40 pl-3">
                <form id="searchForm" method="GET" action="{{ route('history.index') }}">
                    <div class="flex flex-row">
                        <div class="form-group w-60">
                            <input type="text" name="search" class="form-control" placeholder="Search by Courier's Name">
                        </div>
                        <div class="form-group self-center">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 active:bg-red-700">Search</button>
                        </div>
                        </div>
                    </form>
                <form id="filterForm" method="GET" action="{{ route('history.index') }}">
                    <input type="hidden" id="filter" name="filter">
                    <div class="flex flex-row">
                    <select class="border-red-400 mx-2" id="shippingMethod" onchange="updateFilter()">
                        <option value="">Select shipping method</option>
                        <option value="water" {{ ($shippingMethod == 'water') ? 'selected' : '' }}>Laut</option>
                        <option value="air" {{ ($shippingMethod == 'air') ? 'selected' : '' }}>Udara</option>
                    </select>
                    <div class=" max-h-40 overflow-y-auto">
                    <select class="border-red-400 mx-2 " id="shippingLocation" onchange="updateFilter()">
                        <option value="">Select Shipping Location</option>
                        @foreach ($karyawan as $k)
                            <option value="{{ $k->nama }}" {{ ($shippingLocation == $k->id) ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                        <!-- <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option> -->
                    </select>
                    </div>
                    <select class="border-red-400 mx-2" id="shippingStatus" onchange="updateFilter()">
                        <option value="">Select shipping Status</option>
                        <option value="coll" {{ ($shippingStatus == 'coll') ? 'selected' : '' }}>Collected</option>
                        <option value="delv" {{ ($shippingStatus == 'delv') ? 'selected' : '' }}>Delivering</option>
                        <option value="sent" {{ ($shippingStatus == 'sent') ? 'selected' : '' }}>Sent</option>
                    </select>
                    <div class="form-group self-center">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 active:bg-red-700">Filter</button>
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