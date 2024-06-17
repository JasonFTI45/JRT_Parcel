<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Resi') }}
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

                    <h3>Penerima</h3>
                    <label for="penerima_nama">Nama:</label>
                    <input type="text" id="penerima_nama" name="penerima_nama" required>
                    <label for="penerima_nomorTelepon">Nomor Telepon:</label>
                    <input type="text" id="penerima_nomorTelepon" name="penerima_nomorTelepon" required>
                    <label for="penerima_alamat">Alamat:</label>
                    <textarea id="penerima_alamat" name="penerima_alamat" required></textarea>

                    <h3>Pengirim</h3>
                    <label for="pengirim_nama">Nama:</label>
                    <input type="text" id="pengirim_nama" name="pengirim_nama" required>
                    <label for="pengirim_nomorTelepon">Nomor Telepon:</label>
                    <input type="text" id="pengirim_nomorTelepon" name="pengirim_nomorTelepon" required>
                    <label for="pengirim_alamat">Alamat:</label> 
                    <textarea id="pengirim_alamat" name="pengirim_alamat" required></textarea>

                    <!-- <h3>Jenis Pengiriman</h3> -->
                    <label for="jenisPengiriman">Jenis Pengiriman:</label>
                    <select id="jenisPengiriman" name="jenisPengiriman" required>
                        <option value="Udara">Udara</option>
                        <option value="Laut">Laut</option>
                    </select>

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
                            <label for="tipe_komoditas">Tipe Komoditas:</label>
                            <input type="text" name="barang[0][tipe_komoditas]" required>
                            <label for="lebar">Lebar:</label>
                            <input type="number" name="barang[0][lebar]" required>
                            <label for="panjang">Panjang:</label>
                            <input type="number" name="barang[0][panjang]" required>
                            <label for="tinggi">Tinggi:</label>
                            <input type="number" name="barang[0][tinggi]" required>
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
            <label for="tipe_komoditas">Tipe Komoditas:</label>
            <input type="text" name="barang[${barangIndex}][tipe_komoditas]" required>
            <label for="lebar">Lebar:</label>
            <input type="number" name="barang[${barangIndex}][lebar]" required>
            <label for="panjang">Panjang:</label>
            <input type="number" name="barang[${barangIndex}][panjang]" required>
            <label for="tinggi">Tinggi:</label>
            <input type="number" name="barang[${barangIndex}][tinggi]" required>
            <button type="button" onclick="removeBarang(this)">Remove</button>
        `;
        container.appendChild(newBarang);
        barangIndex++;
    }

    function removeBarang(button) {
        button.parentNode.remove();
    }
</script>