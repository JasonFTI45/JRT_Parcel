<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Resi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <h2 class="font-bold text-2xl mb-2">{{ __('Detail Pengiriman') }} ({{ $resi->created_at->format('d-m-Y') }})</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="font-bold">{{ __('Kode Resi') }}</p>
                            <p>{{ $resi->kodeResi }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Jenis Pengiriman') }}</p>
                            <p>{{ $resi->jenisPengiriman }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Penerima') }}</p>
                            <p>{{ $resi->penerima->namaPenerima }}</p>
                            <p>{{ $resi->penerima->nomorTelepon }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Pengirim') }}</p>
                            <p>{{ $resi->pengirim->namaPengirim }}</p>
                            <p>{{ $resi->pengirim->nomorTelepon }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Kecamatan/Kota Asal') }}</p>
                            <p>{{ $resi->kecamatan_kota_asal }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Kecamatan/Kota Tujuan') }}</p>
                            <p>{{ $resi->kecamatan_kota_tujuan }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Alamat Tujuan') }}</p>
                            <p>{{ $resi->pengirim->alamat }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Biaya Pengiriman') }}</p>
                            <p>{{ 'Rp ' . number_format($resi->harga, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <h2 class="font-bold text-2xl mb-2">{{ __('Detail Barang') }}</h2>
                    <div class="mb-4">
                        <p class="font-bold">{{ __('Jumlah Koli') }}</p>
                        <p>{{ $resi->barangs->count() }}</p>
                    </div>
                    @foreach ( $resi->barangs as $barang )
                    <div>
                        <h2 class="font-bold text-xl mb-1">{{ __('Barang ') . $loop->index+1 }}  </h2>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="font-bold">{{ __('Tipe') }}</p>              
                            <p>{{ $barang->tipe_komoditas }}</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Berat') }}</p>
                            <p>{{ $barang->berat }} kg</p>
                        </div>
                        <div>
                            <p class="font-bold">{{ __('Volume') }}</p>
                            <p>{{ $barang->panjang }} cm x {{ $barang->lebar }} cm x {{ $barang->tinggi }} cm</p>
                        </div>
                    </div>      
                    @endforeach                                 
                </div>
            </div>
            <a href="{{ route('resi.print', $resi->id) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Print') }}
            </a>
        </div>
    </div>
</x-app-layout>
