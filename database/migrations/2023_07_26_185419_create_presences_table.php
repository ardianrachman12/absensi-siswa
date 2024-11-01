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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id');
            $table->foreignId('inputby_id');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
        Schema::table('presence', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0); // 0: Belum absen, 1: Berhasil absen, 2: Izin
        });
    }
};
