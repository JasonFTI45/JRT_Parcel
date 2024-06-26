<!-- HALAMAN UNTUK MEMPERBARUI DETAIL PAKET DAN MENGUBAH STATUS PENGIRIMAN -->
<!-- STATUS PENGIRIMAN BERISI (MENUNGGU PENGIRIMAN, SEDANG DIKIRIM, SUDAH SAMPAI) -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('resi.index') }}" class="text-blue-500 hover:text-blue-700">&larr; {{ __('Kembali') }}</a>
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                @endif
                <form action="{{ route('resi.update', $resi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Detail Pengiriman') }}</h3>
                        <div class="border p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-6">
                                    <x-input-label for="jenisPengiriman" :value="__('Jenis Pengiriman')" />
                                    <x-select-input 
                                        id="jenisPengiriman" 
                                        name="jenisPengiriman" 
                                        :options="['Udara' => 'Udara', 'Laut' => 'Laut']"
                                        selected="{{$resi->jenisPengiriman}}"
                                        required
                                    />
                                </div>
                                <div class="mb-6">
                                    <x-input-label for="status" :value="__('Status Pengiriman')" />
                                    <x-select-input 
                                        id="status" 
                                        name="status" 
                                        :options="['Menunggu Pengiriman' => 'Menunggu Pengiriman', 'Sedang Dikirim' => 'Sedang Dikirm', 'Sudah Sampai' => 'Sudah Sampai']"
                                        selected="{{$resi->status}}"
                                        required
                                    />
                                </div>
                            </div>
                            
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-dropdown-search-input
                                        id="kecamatan_kota_asal" 
                                        name="kecamatan_kota_asal" 
                                        label="Kecamatan, Kota Asal"
                                        :disabled="true"
                                        defaultText="TAMBORA, JAKARTA BARAT"
                                        :required="true"
                                    />

                                    <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Pengirim') }}</h3>
                                    <x-input-label for="pengirim_nama" :value="__('Nama')" />
                                    <x-text-input type="text" id="pengirim_nama" name="pengirim_nama" value="{{ $resi->pengirim->namaPengirim }}" required />

                                    <x-input-label for="pengirim_nomorTelepon" :value="__('Nomor Telepon')" />
                                    <x-text-input type="text" id="pengirim_nomorTelepon" name="pengirim_nomorTelepon" value="{{ $resi->pengirim->nomorTelepon }}" required />

                                    <x-input-label for="pengirim_alamat" :value="__('Alamat')" />
                                    <x-text-area id="pengirim_alamat" name="pengirim_alamat" rows="4" value="{{ $resi->pengirim->alamat }}" required />
                                </div>
                                @php
                                    $items = $lokasi->map(function($item) {
                                        return $item->kecamatan . ', ' . $item->kota;
                                    })->toArray();
                                @endphp
                                <div>
                                    <x-dropdown-search-input
                                        id="kecamatan_kota_tujuan" 
                                        name="kecamatan_kota_tujuan" 
                                        label="Kecamatan, Kota Tujuan"
                                        :items="$items"
                                        placeholder="Search Kecamatan/Kota..."
                                        :required="true"
                                        defaultText="{{ $resi->kecamatan_kota_tujuan }}"
                                        initialQuery=""
                                        :disabled="false"
                                    />

                                    <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Penerima') }}</h3>
                                    <x-input-label for="penerima_nama" :value="__('Nama')" />
                                    <x-text-input type="text" id="penerima_nama" name="penerima_nama" value="{{ $resi->penerima->namaPenerima }}" required />

                                    <x-input-label for="penerima_nomorTelepon" :value="__('Nomor Telepon')" />
                                    <x-text-input type="text" id="penerima_nomorTelepon" name="penerima_nomorTelepon" value="{{ $resi->penerima->nomorTelepon }}" required />

                                    <x-input-label for="penerima_alamat" :value="__('Alamat')" />
                                    <x-text-area id="penerima_alamat" name="penerima_alamat" rows="4" value="{{ $resi->penerima->alamat }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Detail Barang') }}</h3>
                        <div id="barang-container" class="space-y-4">
                            
                        @foreach ($resi->barangs as $barang)
                        
                        
                            <div class="barang-item border p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Jenis Barang') }}</h3>
                                        <x-input-label for="tipe_komoditas" :value="__('Tipe Komoditas')" />
                                        <x-text-input type="text" name="barang[{{ $loop->index }}][tipe_komoditas]" value="{{ $barang->tipe_komoditas }}" required />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Berat Barang') }} <span class="text-gray-500 text-sm">{{ __('(Kg)*') }}</span></h3>
                                        <x-input-label for="berat" :value="__('Berat')" />
                                        <x-number-input type="number" step="0.01" name="barang[{{ $loop->index }}][berat]" value="{{ $barang->berat }}" required />
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Dimensi Barang') }} <span class="text-gray-500 text-sm">{{ __('(PxLxT) cm*') }}</span></h3>
                                    <div class="flex flex-row">
                                        <div style="margin-right:30px;">
                                            <x-input-label for="panjang" :value="__('Panjang')" />
                                            <x-number-input type="number" name="barang[{{ $loop->index }}][panjang]" value="{{ $barang->panjang }}" required />
                                        </div>
                                        <div style="margin-right: 30px;">
                                            <x-input-label for="lebar" :value="__('Lebar')" />
                                            <x-number-input type="number" name="barang[{{ $loop->index }}][lebar]" value="{{ $barang->lebar }}" required />
                                        </div>
                                        <div>
                                            <x-input-label for="tinggi" :value="__('Tinggi')" />
                                            <x-number-input type="number" name="barang[{{ $loop->index }}][tinggi]" value="{{ $barang->tinggi }}" required />
                                        </div>
                                    </div>
                                </div>
                                @if($loop->index > 0)
                                    <button type="button" class="remove-barang mt-4 text-red-500 hover:text-red-700">
                                        {{ __('Remove') }}
                                    </button>
                                @endif
                            </div>  
                            @endforeach                               
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="addBarang()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    {{ __('+ Add Barang') }}
                                </button>
                            </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg mt-4 mb-2">{{ __('Detail Biaya Pengiriman') }}</h3>
                        <div class="border p-4 rounded-md">
                            
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                            <div>
                                <h3 class="font-semibold text-lg mb-2">{{ __('Jenis Pembayaran') }}</h3>
                                <x-radio-input name="metodePembayaran" value="Transfer" label="Transfer" required :checked="$resi->metodePembayaran === 'Transfer'"/>
                                <x-radio-input name="metodePembayaran" value="Cash" label="Cash" required :checked="$resi->metodePembayaran === 'Cash'"/>
                                <x-radio-input name="metodePembayaran" value="COD" label="COD" required :checked="$resi->metodePembayaran === 'COD'"/>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">{{ __('Status Pembayaran') }}</h3>
                                <x-radio-input name="statusPembayaran" value="Lunas" label="Lunas" required :checked="$resi->statusPembayaran === 'Lunas'"/>
                                <x-radio-input name="statusPembayaran" value="Belum Lunas" label="Belum Lunas" required :checked="$resi->statusPembayaran === 'Belum Lunas'"/>
                            </div>
                        </div>
                            
                            <button type="button" id="calculateHargaBtn" class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Hitung Harga') }}
                            </button>
                            <div id="hargaDisplay" class="float-right p-4 text-3xl font-bold">
                                {{ 'Rp ' . number_format($resi->harga, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                                
                        
                        
                        
                        <button type="submit" class="mt-6 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        {{ __('Update Resi') }}
                        </button>
                            </div>
                        </div>
                    </div>        
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let barangIndex = {{ count($resi->barangs) }};

    function addBarang() {
        const container = document.getElementById('barang-container');
        const newBarang = document.createElement('div');
        newBarang.classList.add('barang-item', 'border', 'p-4', 'rounded-md');
        newBarang.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-lg mt-4 mb-2">Jenis Barang</h3>
                <x-input-label for="tipe_komoditas" :value="__('Tipe Komoditas')" />
                <x-text-input type="text" name="barang[${barangIndex}][tipe_komoditas]" required />
            </div>
            <div>
                <h3 class="font-semibold text-lg mt-4 mb-2">Berat Barang <span class="text-gray-500 text-sm">(Kg)*</span></h3>
                <x-input-label for="berat" :value="__('Berat')" />
                <x-number-input type="number" step="0.01" name="barang[${barangIndex}][berat]" required />
            </div>
            <div>
                <h3 class="font-semibold text-lg mt-4 mb-2">Dimensi Barang</h3>
                <div class="flex flex-row">
                <div style="margin-right:30px;">
                    <x-input-label for="panjang" :value="__('Panjang')" />
                    <x-number-input type="number" name="barang[${barangIndex}][panjang]" required />
                </div>
                <div style="margin-right: 30px;">
                    <x-input-label for="lebar" :value="__('Lebar')" />
                    <x-number-input type="number" name="barang[${barangIndex}][lebar]" required />
                </div>
                <div>
                    <x-input-label for="tinggi" :value="__('Tinggi')" />
                    <x-number-input type="number" name="barang[${barangIndex}][tinggi]" required />
                </div>
                </div>
            </div>
            </div>
            <button type="button" onclick="removeBarang(this)" class="mt-4 text-red-500 hover:text-red-700">Remove</button>
        `;
        container.appendChild(newBarang);
        barangIndex++;
    }

    function removeBarang(button) {
        button.parentNode.remove();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const barangContainer = document.getElementById('barang-container'); // Make sure you have this container in your HTML
        barangContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-barang')) {
                e.target.closest('.barang-item').remove();
            }
        });
    });

    document.getElementById('calculateHargaBtn').addEventListener('click', function() {
    const kecamatanKotaTujuan = document.querySelector('[name="kecamatan_kota_tujuan"]').value;
    const jenisPengiriman = document.querySelector('[name="jenisPengiriman"]').value;
    
    // Initialize an empty array to hold all barang data
    const barangData = [];
    
    // Find all elements that have a name attribute starting with 'barang['
    document.querySelectorAll('[name^="barang["]').forEach(element => {
        // Extract the indexes and field name from the element's name attribute
        const matches = element.name.match(/^barang\[(\d+)\]\[(\w+)\]$/);
        if (matches) {
            const index = matches[1];
            const field = matches[2];
            
            // Initialize the object at this index if it doesn't already exist
            if (!barangData[index]) {
                barangData[index] = {};
            }
            
            // Add the field's value to the corresponding object
            barangData[index][field] = element.value;
        }
    });

    function formatRupiah(amount) {
    return 'Rp' + parseInt(amount, 10).toLocaleString('id-ID');
    }
    
    axios.post('/calculate-harga', {
        kecamatan_kota_tujuan: kecamatanKotaTujuan,
        jenisPengiriman: jenisPengiriman,
        barang: barangData,
    })
    .then(function (response) {
        document.getElementById('hargaDisplay').innerText = formatRupiah(response.data.harga);
    })
    .catch(function (error) {
        console.log(error);
    });
});
</script>
