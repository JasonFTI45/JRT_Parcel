<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                @endif
                <form action="{{ route('resi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')
                    <div>
                        <h3 class="font-semibold text-lg mt-4 mb-2">Detail Pengiriman</h3>
                        <div class="border p-4 rounded-md">
                            <div class="mb-6">
                                <x-input-label for="jenisPengiriman" :value="__('Jenis Pengiriman')" />
                                <x-select-input 
                                    id="jenisPengiriman" 
                                    name="jenisPengiriman" 
                                    :options="['Udara' => 'Udara', 'Laut' => 'Laut']"
                                    selected="Udara"
                                    required
                                />
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

                                    <h3 class="font-semibold text-lg mt-4 mb-2">Pengirim</h3>
                                    <x-input-label for="pengirim_nama" :value="__('Nama')" />
                                    <x-text-input type="text" id="pengirim_nama" name="pengirim_nama" required />

                                    <x-input-label for="pengirim_nomorTelepon" :value="__('Nomor Telepon')" />
                                    <x-text-input type="text" id="pengirim_nomorTelepon" name="pengirim_nomorTelepon" required />

                                    <x-input-label for="pengirim_alamat" :value="__('Alamat')" />
                                    <x-text-area id="pengirim_alamat" name="pengirim_alamat" rows="4" required />
                                </div>
                                
                                <div>
                                    <x-dropdown-search-input
                                        id="kecamatan_kota_tujuan" 
                                        name="kecamatan_kota_tujuan" 
                                        label="Kecamatan, Kota Tujuan"
                                        :items="['SINGKAWANG BARAT, SINGKAWANG', 'SINGKAWANG SELATAN, SINGKAWANG', 'SINGKAWANG TENGAH, SINGKAWANG', 'SINGKAWANG TIMUR, SINGKAWANG', 'SINGKAWANG UTARA, SINGKAWANG', 'SUNGAI PINYUH, MEMPAWAH']"
                                        placeholder="Search Kecamatan/Kota..."
                                        :required="true"
                                        initialQuery=""
                                        :disabled="false"
                                    />

                                    <h3 class="font-semibold text-lg mt-4 mb-2">Penerima</h3>
                                    <x-input-label for="penerima_nama" :value="__('Nama')" />
                                    <x-text-input type="text" id="penerima_nama" name="penerima_nama" required />

                                    <x-input-label for="penerima_nomorTelepon" :value="__('Nomor Telepon')" />
                                    <x-text-input type="text" id="penerima_nomorTelepon" name="penerima_nomorTelepon" required />

                                    <x-input-label for="penerima_alamat" :value="__('Alamat')" />
                                    <x-text-area id="penerima_alamat" name="penerima_alamat" rows="4" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-lg mt-4 mb-2">Detail Barang</h3>
                        <div id="barang-container" class="space-y-4">
                            
                            <div class="barang-item border p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h3 class="font-semibold text-lg mt-4 mb-2">Jenis Barang</h3>
                                        <x-input-label for="tipe_komoditas" :value="__('Tipe Komoditas')" />
                                        <x-text-input type="text" name="barang[0][tipe_komoditas]" required />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg mt-4 mb-2">Berat Barang <span class="text-gray-500 text-sm">(Kg)*</span></h3>
                                        <x-input-label for="berat" :value="__('Berat')" />
                                        <x-number-input type="number" step="0.01" name="barang[0][berat]" required />
                                    </div>
                                </div>
                                <div>
                                        <h3 class="font-semibold text-lg mt-4 mb-2">Dimensi Barang <span class="text-gray-500 text-sm">(PxLxT) cm*</span></h3>
                                        <div class="flex flex-row">
                                            <div style="margin-right:30px;">
                                                <x-input-label for="panjang" :value="__('Panjang')" />
                                                <x-number-input type="number" name="barang[0][panjang]" required />
                                            </div>
                                            <div style="margin-right: 30px;">
                                                <x-input-label for="lebar" :value="__('Lebar')" />
                                                <x-number-input type="number" name="barang[0][lebar]" required />
                                            </div>
                                            <div>
                                                <x-input-label for="tinggi" :value="__('Tinggi')" />
                                                <x-number-input type="number" name="barang[0][tinggi]" required />
                                            </div>
                                        </div>
                                        </div>

                                        </div>
                                        
                                </div>
                            </div>
                            <button type="button" onclick="addBarang()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Barang</button>
                            <button type="submit" class="mt-6 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Submit</button>
                        </div>
                        
                    </div>        
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let barangIndex = 1;

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
</script>
