<!-- HALAMAN UNTUK MELAKUKAN PRINT RESI KETIKA LOGIN SEBAGAI ADMIN -->
<!-- RESI DIPRINT DALAM BENTUK PDF DAN TERSIMPAN DENFAN NAMA JRTParcel.pdf -->

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
                <h2>{{ __('Tanggal : ') . $resi->created_at->format('d-m-Y') }}</h2>
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
                    @if ($resi->metodePembayaran == 'Transfer' || $resi->metodePembayaran == 'Cash')
                        <h1>CASHLESS</h1>
                    @elseif ($resi->metodePembayaran == 'COD')
                        <h1>COD</h1>
                    @endif
                </div>
                @if ($resi->metodePembayaran == 'Transfer' || $resi->metodePembayaran == 'Cash')
                        <div class="right-resi-2"><i>Penerima tidak perlu membayar ongkir ke Kurir</i></div>
                    @elseif ($resi->metodePembayaran == 'COD')
                        <div class="right-resi-2"><i>Penerima harus membayar ongkir ke Kurir</i></div>
                @endif
                
            </div>
            <div class="tujuan-resi">
                <h1>{{ __('Jumlah Koli: ') . $resi->barangs->count() }}</h1>
                <h1 class="mr" style="font-weight: bolder;">{{ __('Total Berat Volume : ') . $resi->barangs->sum('beratVolume') . ' Kg'}}</h1>
                <h1 class="mr" style="font-weight: bolder;">{{ __('Total Berat Barang : ') . $resi->barangs->sum('berat') . ' Kg'}}</h1>
            </div>
        </div>
        <div class="tabel-resi">
            <table>
                <tr style="font-weight: bolder;">
                    <td>#</td>
                    <td>Tipe</td>
                    <td>Volume</td>
                    <td>Berat Volume</td>
                    <td>Berat Barang</td>
                </tr>
                @foreach ( $resi->barangs as $barang )
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $barang->tipe_komoditas }}</td>
                    <td>{{ $barang->panjang }} cm x {{ $barang->lebar }} cm x {{ $barang->tinggi }} cm</td>
                    <td>{{ $barang->beratVolume }} Kg</td>
                    <td>{{ $barang->berat }} Kg</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="total-resi">
            <h1 style="font-weight: bolder;">{{ __('Biaya Pengiriman : ') . 'Rp ' . number_format($resi->harga, 2, ',', '.') }}</h1>
        </div>
    </div>
    
    <div class="container-penerima">
    <b style="margin-left: 10px;"><i>&#9988; Lembar Pengirim</i></b>
        <div class="content-resi penerima">
            <div class="penerima-isi-1">
                <div class="isi-1-top">
                    <img src="{{ asset('assets/logo.png') }}" alt="" height="30" width="57.25">
                </div>
                <div class="isi-1-bottom">
                    <table>
                        <tbody>
                            @foreach([
                            'Pengirim' => $resi->pengirim->namaPengirim,
                            'Penerima' => $resi->penerima->namaPenerima,
                            'Kota Tujuan' => $resi->kecamatan_kota_tujuan,
                            'Tanggal Kirim' => $resi->created_at->format('d-m-Y'),
                            'Estimasi' => ($resi->jenisPengiriman == 'Udara') ? '2-3 Hari' : (($resi->jenisPengiriman == 'Laut') ? '7-10 Hari' : '')
                            ] as $label => $value)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>:</td>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="penerima-isi-2">
                <div class="isi-1-top column">
                    <h2 style="font-size: 18px; ">{{ __('Pengiriman ') . $resi->jenisPengiriman }}</h2>
                    <h5>({{ $resi->created_at->format('d-m-Y') }})</h5>
                </div>
                <div class="isi-1-bottom">
                    <table>
                        <tbody class="font-12">
                            @foreach([
                            'No. Resi' => $resi->kodeResi,
                            'Total Berat Barang' => $resi->barangs->sum('berat') . ' Kg',
                            'Total Berat Volume' => $resi->barangs->sum('beratVolume') . ' Kg',
                            'Jumlah Koli' => $resi->barangs->count()
                            ] as $label => $value)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>:</td>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="isi-1-top harga">
                    <h1>{{'Rp. ' . number_format($resi->harga, 2, ',', '.')}}</h1>
                </div>
            </div>
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