<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div>{{ session('success') }}</div>
                @endif
                <form action="{{ route('resi.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <x-input-label for="penerima_nama" :value="__('Nama Penerima')"/>
                    <x-text-input type="text" id="penerima_nama" name="penerima_nama" required/>
                    <x-input-label for="penerima_nomorTelepon" :value="__('Nomor Telepon')"/>
                    <x-text-input type="text" id="penerima_nomorTelepon" name="penerima_nomorTelepon" required/>
                    <x-input-label for="penerima_alamat" :value="__('Alamat')"/>
                    <x-text-area id="penerima_alamat" name="penerima_alamat" rows=4 required/>

                    <h3>Pengirim</h3>
                    <x-input-label for="pengirim_nama" :value="__('Nama')"/>
                    <x-text-input type="text" id="pengirim_nama" name="pengirim_nama" required/>
                    <x-input-label for="pengirim_nomorTelepon" :value="__('Nomor Telepon')"/>
                    <x-text-input type="text" id="pengirim_nomorTelepon" name="pengirim_nomorTelepon" required/>
                    <x-input-label for="pengirim_alamat" :value="__('Alamat')"/>
                    <x-text-area id="pengirim_alamat" name="pengirim_alamat" rows=4 required/>

                    <x-input-label for="jenisPengiriman" :value="__('Jenis Pengiriman')"/>
                    <x-select-input 
                    id="jenisPengiriman" 
                    name="jenisPengiriman" 
                    :options="['Udara' => 'Udara', 'Laut' => 'Laut']"
                    selected="Udara"
                    required
                    />

                    <x-dropdown-search-input
                        id="kecamatan_kota_asal" 
                        name="kecamatan_kota_asal" 
                        label="Kecamatan, Kota Asal"
                        :disabled="true"
                        defaultText="TAMBORA, JAKARTA BARAT"
                        :required="true"
                    />

                    <x-dropdown-search-input
                        id="kecamatan_kota_tujuan" 
                        name="kecamatan_kota_tujuan" 
                        label="Kecamatan, Kota Asal"
                        :items="['SINGKAWANG BARAT, SINGKAWANG', 'SINGKAWANG SELATAN, SINGKAWANG', 'SINGKAWANG TENGAH, SINGKAWANG', 'SINGKAWANG TIMUR, SINGKAWANG', 'SINGKAWANG UTARA, SINGKAWANG', 'SUNGAI PINYUH, MEMPAWAH',]"
                        placeholder="Search Kecamatan/Kota..."
                        :required="true"
                        initialQuery=""
                        :disabled="false"
                    />

                    <h3>Barang</h3>
                    <div id="barang-container">
                        <!-- Existing Barang item -->
                        <div class="barang-item">
                            <x-input-label for="tipe_komoditas" :value="__('Tipe Komoditas')"/>
                            <x-text-input type="text" name="barang[0][tipe_komoditas]" required/>
                            <x-input-label for="lebar" :value="__('Lebar')"/>
                            <x-number-input type="number" name="barang[0][lebar]" required/>
                            <x-input-label for="panjang" :value="__('Panjang')"/>
                            <x-number-input type="number" name="barang[0][panjang]" required/>
                            <x-input-label for="tinggi" :value="__('Tinggi')"/>
                            <x-number-input type="number" name="barang[0][tinggi]" required/>
                            <button type="button" onclick="removeBarang(this)">Remove</button>
                        </div>
                    </div>
                    <button type="button" onclick="addBarang()">Add Barang</button>
                    <button type="submit">Submit</button>
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
        newBarang.classList.add('barang-item');
        newBarang.innerHTML = `
            <x-input-label for="tipe_komoditas" :value="__('Tipe Komoditas')"/>
            <x-text-input type="text" name="barang[${barangIndex}][tipe_komoditas]" required/>
            <x-input-label for="lebar" :value="__('Lebar')"/>
            <x-number-input type="number" name="barang[${barangIndex}][lebar]" required/>
            <x-input-label for="panjang" :value="__('Panjang')"/>
            <x-number-input type="number" name="barang[${barangIndex}][panjang]" required/>
            <x-input-label for="tinggi" :value="__('Tinggi')"/>
            <x-number-input type="number" name="barang[${barangIndex}][tinggi]" required/>
            <button type="button" onclick="removeBarang(this)">Remove</button>
        `;
        container.appendChild(newBarang);
        barangIndex++;
    }

    function removeBarang(button) {
        button.parentNode.remove();
    }
</script>
