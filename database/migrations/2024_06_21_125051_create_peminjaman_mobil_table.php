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
        Schema::create('peminjaman_mobil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobil_id');
            $table->bigInteger('user_id');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->string('status');
            $table->string('total_harga')->nullable();
            $table->timestamps();
        });

        Schema::table('peminjaman_mobil', function (Blueprint $table) {
            $table->foreign('mobil_id')->references('id')->on('mobil');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_mobil');
    }
};
