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
                            <input type="text" name="search" class="form-control" placeholder="Search by name">
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
                    <select class="border-red-400 mx-2" id="shippingLocation" onchange="updateFilter()">
                        <option value="">Select Shipping Location</option>
                        <option value="singkawang" {{ ($shippingLocation == 'singkawang') ? 'selected' : '' }}>Singkawang</option>
                        <option value="pontianak" {{ ($shippingLocation == 'pontianak') ? 'selected' : '' }}>Pontianak</option>
                    </select>
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
                <div class="card">
                    <div class="card-body overscroll-contain px-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Nomor Telepon</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawan as $k)
                                    <tr">
                                        <td class ="text-red-500 hover:text-red-700">{{ $k->nama }}</td>
                                        <td>{{ $k->nomor_telepon }}</td>
                                        <td>{{ $k->email }}</td>
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