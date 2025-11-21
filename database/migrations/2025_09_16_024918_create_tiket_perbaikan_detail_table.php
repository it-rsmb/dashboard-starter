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
        Schema::create('tiket_perbaikan_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tiket_id');  // relasi ke tiket_perbaikan
            $table->unsignedBigInteger('aset_id');   // relasi ke tabel aset

            $table->text('masalah');
            $table->text('penanganan')->nullable();
            $table->string('ruangan')->nullable();
            $table->unsignedBigInteger('petugas');
            $table->dateTime('waktu_penanganan');

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
        Schema::dropIfExists('tiket_perbaikan_detail');
    }
};
