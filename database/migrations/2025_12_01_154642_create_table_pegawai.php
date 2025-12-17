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
        Schema::create('jibrilian_542393_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pekerjaan_id')->constrained('jibrilian_542393_pekerjaan')->cascadeOnDelete();
            $table->string('nama');
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
