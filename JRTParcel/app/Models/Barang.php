<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'tipe_komoditas',
        'lebar',
        'panjang',
        'tinggi',
        'resi_id',
    ];

    public function resi()
    {
        return $this->belongsTo(Resi::class, 'resi_id');
    }
}
