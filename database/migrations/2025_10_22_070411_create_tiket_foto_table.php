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
        Schema::create('tiket_foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tiket_id');
            $table->string('gambar', 255)->nullable(); // path atau nama file gambar
            $table->text('keterangan')->nullable();   // deskripsi tambahan
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
        Schema::dropIfExists('tiket_foto');
    }
};
