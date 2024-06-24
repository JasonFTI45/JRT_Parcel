<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resi;
use App\Models\Karyawan;
use App\Models\Penerima;
use App\Models\Pengirim;
use App\Models\Lokasi;
use App\Models\Barang;

class ResiSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $pengirim = Pengirim::create([
                'namaPengirim' => "Pengirim $i",
                'nomorTelepon' => '08123456789' . $i,
                'alamat' => "Alamat Pengirim $i",
            ]);

            $penerima = Penerima::create([
                'namaPenerima' => "Penerima $i",
                'nomorTelepon' => '08123456798'. $i,
                'alamat' => "Alamat Penerima $i",
            ]);

            $resiData = [
                'kodeResi' => 'RS' . str_pad($i, 9, "0", STR_PAD_LEFT),
                'jenisPengiriman' => 'REGULER',
                'penerima_id' => $penerima->id, 
                'pengirim_id' => $pengirim->id, 
                'kecamatan_kota_asal' => 'KUBU RAYA',
                'kecamatan_kota_tujuan' => 'SINGKAWANG BARAT',
                'harga' => 50000 * $i,
                'metodePembayaran' => 'Cash',
                'statusPembayaran' => 'Lunas',
                'karyawan_id' => 1, 
                'status' => 'Menunggu Pengiriman'
            ];

            $resi = Resi::create($resiData);

            $barangData = [
                [
                    'tipe_komoditas' => 'Buku',
                    'berat' => 1.5, 
                    'beratVolume'=> 1.5,
                    'lebar' => 10, 
                    'panjang'=> 10,
                    'tinggi' => 10,
                    'resi_id' => $resi->id
                ],
                [
                    'tipe_komoditas' => 'Pensil',
                    'berat' => 0.5, 
                    'beratVolume' => 0.5,
                    'lebar' => 5,
                    'panjang' => 5,
                    'tinggi' => 5,
                    'resi_id' => $resi->id
                ]
            ];

            foreach ($barangData as $data) {
                Barang::create($data);
            }
        }
    }
}