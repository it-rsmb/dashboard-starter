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
        Schema::create('tiket_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket')->unique();
            $table->string('pembuat_tiket'); // id user peminta
            $table->dateTime('tgl_pembuatan')->nullable();
            $table->string('departemen')->nullable();
            $table->string('ruangan')->nullable();
            $table->string('subjek_tiket');
            $table->text('desc_tiket');
            $table->string('petugas_proses')->nullable();
            $table->dateTime('tgl_proses')->nullable();

            $table->string('petugas_pending')->nullable();
            $table->dateTime('tgl_pending')->nullable();
            $table->text('desc_pending')->nullable();

            $table->string('petugas_done')->nullable();
            $table->dateTime('tgl_done')->nullable();
            $table->text('desc_done')->nullable();
            $table->string('departemen_done')->nullable();
            $table->string('ruangan_done')->nullable();
            $table->tinyInteger('kategori_tiket')->comment('1=SIMRS, 2=PSRS');
            $table->tinyInteger('status_tiket')->default(1)->comment('1=waiting, 2=process, 3=pending, 4=done, 5=close');
            $table->tinyInteger('prioritas_tiket')->default(2)->comment('1=Rendah, 2=Sedang, 3=Tinggi');
            $table->string('gambar')->nullable(); // Kolom untuk menyimpan path gambar

            $table->softDeletes();
            $table->timestamps();
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_perbaikan');
    }
};
