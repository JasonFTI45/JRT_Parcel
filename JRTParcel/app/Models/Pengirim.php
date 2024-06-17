<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{
    use HasFactory;

    protected $table = 'pengirim';

    protected $fillable = [
        'namaPengirim',
        'nomorTelepon',
        'alamat',
    ];

    public function resi()
    {
        return $this->hasMany(Resi::class, 'pengirim_id');
    }
}
