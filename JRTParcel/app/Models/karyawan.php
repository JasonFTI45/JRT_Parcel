<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_telepon',
        'email',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function resi()
    {
        return $this->hasMany(Resi::class);
    }

    protected $table = 'karyawan';
}
