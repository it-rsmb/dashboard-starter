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
        Schema::create('admin_tiket', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->tinyInteger('admin_tipe')->comment('1 = SIMRS, 2 = PSRS');
            $table->string('ket', 250)->nullable();
            $table->string('nama_admin', 250)->nullable();
            $table->string('phone_number', 250)->nullable();
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
        Schema::dropIfExists('admin_tiket');
    }
};
