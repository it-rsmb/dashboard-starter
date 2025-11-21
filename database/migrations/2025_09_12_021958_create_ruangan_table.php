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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->unsignedBigInteger('id_unit');
            $table->string('nama_ruangan', 150);
            $table->string('kode_ruangan', 50)->unique()->nullable();
            $table->string('lokasi', 150)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();

            $table->foreign('id_unit')
                  ->references('id_unit')
                  ->on('unit')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
