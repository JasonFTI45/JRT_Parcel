<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToResiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('resi', function (Blueprint $table) {
        $table->decimal('harga',8,2)->default(0)->after('kecamatan_kota_tujuan');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resi', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
}