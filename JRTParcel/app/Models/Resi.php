<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resi extends Model
{
    use HasFactory;

    protected $table = 'resi';

    protected $fillable = [
        'kodeResi',
        'jenisPengiriman',
        'penerima_id',
        'pengirim_id',
        'kecamatan_kota_asal',
        'kecamatan_kota_tujuan',
        'created_at',
        'karyawan_id',
        'status'
    ];

    public function penerima()
    {
        return $this->belongsTo(Penerima::class, 'penerima_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pengirim::class, 'pengirim_id');
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'resi_id');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan', 'karyawan_id');
    }

    // Event listener for creating new Resi
    public static function boot()
    {
        parent::boot();

        static::creating(function ($resi) {
            $resi->kodeResi = $resi->generateKodeResi();
        });
    }

    // Generate kodeResi based on jenisPengiriman
    private function generateKodeResi()
    {
        $prefix = ($this->jenisPengiriman == 'Udara') ? 'U' : 'L';

        $latestResi = DB::table('resi')
                        ->where('jenisPengiriman', $this->jenisPengiriman)
                        ->orderBy('kodeResi', 'desc')
                        ->first();

        if ($latestResi) {
            $latestId = intval(substr($latestResi->kodeResi, 1)) + 1;
        } else {
            $latestId = 1;
        }

        return $prefix . str_pad($latestId, 4, '0', STR_PAD_LEFT);
    }
}
