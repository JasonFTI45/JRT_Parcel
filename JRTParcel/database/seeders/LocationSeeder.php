<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $locations = [
        ['KUBU RAYA', 'PONTIANAK'],
        ['SINGKAWANG BARAT', 'SINGKAWANG'],
        ['SINGKAWANG SELATAN', 'SINGKAWANG'],
        ['SINGKAWANG TENGAH', 'SINGKAWANG'],
        ['SINGKAWANG TIMUR', 'SINGKAWANG'],
        ['SINGKAWANG UTARA', 'SINGKAWANG'],
        ['SUNGAI PINYUH', 'MEMPAWAH'],
        ['ANJONGAN', 'MEMPAWAH'],
        ['MEMPAWAH HILIR', 'MEMPAWAH'],
        ['MEMPAWAH HULU', 'MEMPAWAH'],
        ['MEMPAWAH TIMUR', 'MEMPAWAH'],
        ['SEI/SKAWANG', 'MEMPAWAH'],
        ['MENJALIN', 'MEMPAWAH'],
        ['MERANTI', 'MEMPAWAH'],
        ['KUALA BEHE', 'MEMPAWAH'],
        ['SENGAH TEMILA', 'MEMPAWAH'],
        ['SEMPARUK', 'MEMPAWAH'],
        ['TOHO', 'MEMPAWAH'],
        ['JAWAI', 'MEMPAWAH'],
        ['JAWAI SELATAN', 'MEMPAWAH'],
        ['SADANIANG', 'MEMPAWAH'],
        ['MARAU', 'MEMPAWAH'],
        ['KUALA BEHE', 'MEMPAWAH'],
        ['BENGKAYANG', 'BENGKAYANG'],
        ['CAPKALA', 'BENGKAYANG'],
        ['JAGOI BABANG', 'BENGKAYANG'],
        ['MONTERADO', 'BENGKAYANG'],
        ['TERIAK', 'BENGKAYANG'],
        ['TERIAK TIMUR', 'BENGKAYANG'],
        ['SUNGAI RAYA', 'BENGKAYANG'],
        ['SUNGAI BETUNG', 'BENGKAYANG'],
        ['LEDO', 'BENGKAYANG'],
        ['SUTI SEMARANG', 'BENGKAYANG'],
        ['LUMAR', 'BENGKAYANG'],
        ['SAMALANTAN', 'BENGKAYANG'],
        ['SUNGAI LANDAK', 'BENGKAYANG'],
        ['SUNGAI LANDAK TIMUR', 'BENGKAYANG'],
        ['SUNGAI LANDAK BARAT', 'BENGKAYANG'],
        ['SUNGAI LANDAK UTARA', 'BENGKAYANG'],
        ['SUNGAI LANDAK TENGAH', 'BENGKAYANG'],
        ['SIMPANG HULU', 'BENGKAYANG'],
        ['MONTELU', 'BENGKAYANG'],

    ];

    foreach ($locations as $location) {
        Lokasi::create([
            'kecamatan' => $location[0],
            'kota' => $location[1],
        ]);
    }
    }
}
