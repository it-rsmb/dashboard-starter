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
        Schema::create('aset_mutasi', function (Blueprint $table) {
            $table->id('id_mutasi');
            $table->unsignedBigInteger('id_aset');
            $table->unsignedBigInteger('id_unit_awal')->nullable();
            $table->unsignedBigInteger('id_ruangan_awal')->nullable();
            $table->unsignedBigInteger('id_unit_tujuan')->nullable();
            $table->unsignedBigInteger('id_ruangan_tujuan')->nullable();
            $table->date('tanggal_mutasi');
            $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('aset_mutasi');
    }
};
