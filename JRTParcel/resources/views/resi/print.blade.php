<x-print-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight no-print">
            {{ __('Print Resi') }}
        </h2>
    </x-slot>

    <div class="container-resi">
        <div class="content-resi">
            <div class="logo-resi">
                <img src="{{ asset('assets/logo.png') }}" alt="" height="30" width="57.25">
            </div>
            <div class="judul-resi">
                <h2>Jenis Pengiriman : Udara</h2>
                <h2>No Resi : U0001</h2>
            </div>
            <div class="informasi-resi">
                <div class="penerima-resi">
                    <h1>Penerima: Tigo</h1>
                    <h5>Jl. P. Diponegoro, Melayu, Kec. Singkawang Barat, Kota Singkawang, Kalimantan Barat 79111</h5>

                </div>
                <div class="pengirim-resi">
                    <h1>Pengirim: Ivander</h1>
                    <h5>085216441952</h5>
                    <h5>TAMBORA, JAKARTA BARAT</h5>
                </div>
            </div>
            <div class="tujuan-resi">
                <div class="left-resi">
                    <h1>SINGKAWANG</h1>
                </div>
                <div class="right-resi">
                    <h1>SINGKAWANG BARAT</h1>
                </div>
            </div>
            <div class="tujuan-resi">
                <div class="left-resi-2">
                    <h1>CASHLESS</h1>
                </div>
                <div class="right-resi-2"><i>Penerima tidak perlu membayar ongkir ke Kurir</i></div>
            </div>
            <br>
            <div class="tujuan-resi">
                <h1>Jumlah Koli: 2</h1>
            </div>
        </div>
        <div class="tabel-resi">
            <table>
                <tr style="font-weight: bolder;">
                    <td>#</td>
                    <td>Tipe</td>
                    <td>Berat</td>
                    <td>Volume</td>
                    <td>Harga</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Liquid</td>
                    <td>2 Kg</td>
                    <td>30 cm x 25 cm x 30 cm</td>
                    <td>Rp. 250.000,00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Liquid</td>
                    <td>3 Kg</td>
                    <td>30 cm x 25 cm x 30 cm</td>
                    <td>Rp. 250.000,00</td>
                </tr>
            </table>
        </div>
        <div class="total-resi">
            <h1 style="font-weight: bolder;">Total Harga : Rp. 500.000,00</h1>
        </div>
    </div>


</x-print-layout>
<script>
    window.onload = function() {
        window.print();
    }
</script>

<!-- <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-print">
                    {{ __('Print') }}
            </button> -->

<!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4"> -->
<!-- Updated Test div with a class for printing -->
<!-- <div class="text-gray-900">
                    <p>test</p>
                </div>
            </div> -->