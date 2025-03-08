<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    public function up(): void
    {
        Schema::create('data_table', function (Blueprint $table) {
            $table->id();
            $table->string('kode_provinsi');
            $table->string('nama_provinsi');
            $table->string('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->double('nilai_ikm');
            $table->string('satuan');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_table');
    }
}
