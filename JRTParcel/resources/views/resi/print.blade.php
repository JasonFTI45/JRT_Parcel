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
                <h2> {{ __('Jenis Pengiriman : '. $resi->jenisPengiriman) }} </h2>
                <h2>{{ __('No. Resi : ') . $resi->kodeResi }}</h2>
            </div>
            <div class="informasi-resi">
                <div class="penerima-resi">
                    <h1>{{ __('Penerima: ') . $resi->penerima->namaPenerima }}</h1>
                    <h5>{{ $resi->penerima->alamat }}</h5>
                </div>
                <div class="pengirim-resi">
                    <h1>{{ __('Pengirim: ') . $resi->pengirim->namaPengirim }}</h1>
                    <h5>{{ $resi->pengirim->nomorTelepon }}</h5>
                    <h5>{{ $resi->kecamatan_kota_asal }}</h5>
                </div>
            </div>
            <div class="tujuan-resi">
                <div class="left-resi">
                    <h1>{{ $resi->kecamatan_kota_tujuan }}</h1>
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
                <h1>{{ __('Jumlah Koli: ') . $resi->barangs->count() }}</h1>
            </div>
        </div>
        <div class="tabel-resi">
            <table>
                <tr style="font-weight: bolder;">
                    <td>#</td>
                    <td>Tipe</td>
                    <td>Berat</td>
                    <td>Volume</td>
                </tr>
                @foreach ( $resi->barangs as $barang )
                    <tr>
                        <td>{{ $loop->index + 1}}</td>
                        <td>{{ $barang->tipe_komoditas }}</td>
                        <td>{{ $barang->berat }} Kg</td>
                        <td>{{ $barang->panjang }} cm x {{ $barang->lebar }} cm x {{ $barang->tinggi }} cm</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="total-resi">
            <h1 style="font-weight: bolder;">{{ __('Biaya Pengiriman : ') . 'Rp ' . number_format($resi->harga, 2, ',', '.') }}</h1>
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