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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('code');
            $table->foreignId('class_id');
            $table->foreignId('lesson_id');
            $table->foreignId('createdby_id');
            $table->foreignId('role_id');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->datetime('expiration_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
