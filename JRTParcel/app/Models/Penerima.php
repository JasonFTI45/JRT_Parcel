<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    use HasFactory;

    protected $table = 'penerima';

    protected $fillable = [
        'namaPenerima',
        'nomorTelepon',
        'alamat',
    ];

    public function resi()
    {
        return $this->hasMany(Resi::class, 'penerima_id');
    }
}
