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
        Schema::create('master_aset', function (Blueprint $table) {
            $table->id('id_aset');
            $table->string('kode_aset', 20);
            $table->string('nama_aset', 150);
            $table->string('tipe_aset', 50);
            $table->unsignedBigInteger('id_ruangan')->nullable();
            $table->string('merk', 100)->nullable();
            $table->decimal('kapasitas_pk', 5, 2)->nullable(); // contoh: 1.5 PK
            $table->string('jenis', 100)->nullable();
            $table->string('sn', 100)->nullable(); // serial number
            $table->string('kategori', 100)->nullable()->comment('1 simrs 2 psrs');
            $table->string('lokasi', 150)->nullable();
            $table->date('tanggal_pemasangan')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('nilai', 18, 2)->nullable();
            $table->integer('masa_depresiasi')->nullable(); // dalam tahun
            $table->string('status', 50)->nullable(); // 1 aktif, 0 no aktif
            $table->softDeletes();
            $table->timestamps();
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();

            $table->foreign('id_ruangan')
                  ->references('id_ruangan')
                  ->on('ruangan')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_aset');
    }
};

