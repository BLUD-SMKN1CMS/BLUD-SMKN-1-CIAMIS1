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
        Schema::create('tefas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // AKL, PM, MPLB, dll
            $table->string('name'); // Nama lengkap TEFA
            $table->string('slug')->unique(); // URL friendly
            $table->text('description')->nullable(); // Deskripsi jurusan
            $table->string('logo')->nullable(); // Logo jurusan (opsional)
            $table->string('banner')->nullable(); // Banner jurusan (opsional)
            $table->string('contact_person')->nullable(); // Nama kontak
            $table->string('contact_number')->nullable(); // Nomor HP
            $table->string('contact_email')->nullable(); // Email
            $table->string('whatsapp_url')->nullable(); // Link WhatsApp
            $table->boolean('is_active')->default(true); // Status aktif
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tefas');
    }
};