<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resi_id');
            $table->string('tipe_komoditas');
            $table->float('berat');
            $table->float('lebar');
            $table->float('panjang');
            $table->float('tinggi');
            $table->timestamps();

            $table->foreign('resi_id')->references('id')->on('resi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
