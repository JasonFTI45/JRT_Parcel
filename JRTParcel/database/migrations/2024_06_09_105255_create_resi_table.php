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
        Schema::create('resi', function (Blueprint $table) {
            $table->id();
            $table->string('kodeResi');
            $table->string('jenisPengiriman');
            $table->unsignedBigInteger('penerima_id')->nullable();
            $table->unsignedBigInteger('pengirim_id')->nullable();
            $table->string('kecamatan_kota_asal');
            $table->string('kecamatan_kota_tujuan');
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('penerima_id')->references('id')->on('penerima')->onDelete('set null');
            $table->foreign('pengirim_id')->references('id')->on('pengirim')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resi');
    }
};
