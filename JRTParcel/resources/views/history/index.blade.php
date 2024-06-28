<!-- HALAMAN UNTUK TABEL HISTORI PENGIRIMAN KETIKA LOGIN SEBAGAI ADMIN -->
<!-- PADA HALAMAN INI TERDAPAT FUNCTION PRINT RESI BAGI ADMIN UNTUK MENCETAK RESI -->
<!-- TERDAPAT FITUR SEPERTI SEARCH, FILTER DAN SORT (ASC/DESC) -->

<x-app-layout>

    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-center font-bold text-2xl mb-7">HISTORI PENGIRIMAN</h1>
                <div class="flex max-w-7xl mx-auto border-solid mb-5">
                    <form class="w-full" id="combinedForm" method="GET" action="{{ route('history.index') }}">
                        <div class="flex justify-between">
                            <div class="flex border-solid">
                                <div class="form-group w-40">
                                    <input type="text" name="search" class="form-control rounded w-36 text-sm" placeholder="Search by Karyawan" value="{{ request('search') }}">
                                </div>
                                <div class="form-group self-center">
                                    <button type="submit" name="action" value="search" class="btn-1 font-extrabold">Search</button>
                                </div>
                            </div>

                            <div class="flex flex-row space-x-2">
                                <div class="flex flex-row space-x-2">
                                    <select class="w-44 text-sm rounded" id="shippingMethod" name="shippingMethod" onchange="submitForm()">
                                        <option value="">Shipping Method</option>
                                        <option value="Laut" {{ ($shippingMethod == 'Laut') ? 'selected' : '' }}>Laut</option>
                                        <option value="Udara" {{ ($shippingMethod == 'Udara') ? 'selected' : '' }}>Udara</option>
                                    </select>
                                    <select class="w-40 text-sm rounded max-w-64 " id="shippingLocation" name="shippingLocation" onchange="submitForm()">
                                        <option value="">Shipping Location</option>
                                        @foreach ($lokasi as $lokasi)
                                        <option value="{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}" {{ ($shippingLocation == ($lokasi->kecamatan . ', ' . $lokasi->kota)) ? 'selected' : '' }}>{{ $lokasi->kecamatan }}, {{ $lokasi->kota }}</option>
                                        @endforeach
                                    </select>
                                    <select class="w-40 text-sm rounded" id="shippingStatus" name="shippingStatus" onchange="submitForm()">
                                        <option value="">Shipping Status</option>
                                        <option value="Menunggu Pengiriman" {{ ($shippingStatus == 'Menunggu Pengiriman') ? 'selected' : '' }}>Menunggu Pengiriman</option>
                                        <option value="Sedang Dikirim" {{ ($shippingStatus == 'Sedang Dikirim') ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="Sudah Sampai" {{ ($shippingStatus == 'Sudah Sampai') ? 'selected' : '' }}>Sudah Sampai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-row space-x-2">
                                <div class="flex flex-row space-x-2">
                                    <select class="rounded w-28 text-sm" id="sortField" name="sortField" onchange="submitForm()">
                                        <option value="id" {{ ($sortField == 'id') ? 'selected' : '' }}>No. Resi</option>
                                        <option value="nama" {{ ($sortField == 'nama') ? 'selected' : '' }}>Karyawan</option>
                                        <option value="kecamatan_kota_tujuan" {{ ($sortField == 'kecamatan_kota_tujuan') ? 'selected' : '' }}>Kota Tujuan</option>
                                    </select>
                                    <select class="rounded w-32 text-sm" id="sortOrder" name="sortOrder" onchange="submitForm()">
                                        <option value="asc" {{ ($sortOrder == 'asc') ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ ($sortOrder == 'desc') ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card w-full max-w-full py-4">
                    <div class="card-body overflow-y-auto max-h-500">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left">Resi</th>
                                    <th class="py-3 px-6 text-left">Karyawan</th>
                                    <th class="py-3 px-6 text-left">Pengirim</th>
                                    <th class="py-3 px-6 text-left">Kota Asal</th>
                                    <th class="py-3 px-6 text-left">Kota Tujuan</th>
                                    <th class="py-3 px-6 text-left">Penerima</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-600 text-sm font-light">
                                @foreach ($resi as $r)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $r->kodeResi }}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->karyawan->nama}}<br>{{ $r->karyawan->nomor_telepon}}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->pengirim->namaPengirim }}<br>{{ $r->pengirim->nomorTelepon }}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->kecamatan_kota_asal }}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->kecamatan_kota_tujuan }}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->penerima->namaPenerima }}<br>{{ $r->penerima->nomorTelepon }}</td>
                                    <td class="py-3 px-6 text-left">{{ $r->status }}</td>
                                    <td><a href="{{ route('history.print', $r->id) }}" target="_blank" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Print</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $resi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function submitForm() {
        document.getElementById('combinedForm').submit();
    }
</script>