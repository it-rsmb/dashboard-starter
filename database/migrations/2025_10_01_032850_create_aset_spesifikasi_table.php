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
        Schema::create('aset_spesifikasi', function (Blueprint $table) {
            $table->bigIncrements('id_spesifikasi'); // primary key
            $table->unsignedBigInteger('id_aset');   // relasi ke master_aset
            $table->string('processor', 100)->nullable();
            $table->string('ram', 200)->nullable();
            $table->string('hdd', 200)->nullable();
            $table->string('ssd', 200)->nullable();
            $table->string('vga', 200)->nullable();
            $table->string('motherboard', 200)->nullable();
            $table->string('psu', 200)->nullable();
            $table->text('spesifikasi_lain')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->softDeletes();
            $table->timestamps();
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();

            $table->foreign('id_aset')
                  ->references('id_aset')
                  ->on('master_aset')
                  ->onDelete('cascade'); // hapus spesifikasi kalau aset dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_spesifikasi');
    }
};
