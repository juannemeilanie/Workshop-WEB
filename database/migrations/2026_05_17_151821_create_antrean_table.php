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
        Schema::create('antrean', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('idpoli')->constrained('poli', 'idpoli')->onDelete('cascade');
            $table->integer('nomor');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'terlambat'])->default('menunggu');
            $table->date('tanggal_daftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrean');
    }
};
