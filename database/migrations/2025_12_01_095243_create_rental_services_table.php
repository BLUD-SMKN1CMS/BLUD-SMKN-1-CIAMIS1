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
        Schema::create('rental_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Air Minum, Gedung, Transportasi
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Ikon layanan
            $table->decimal('price_per_unit', 10, 2)->nullable(); // Harga per unit
            $table->string('unit_type')->nullable(); // satuan: liter, hari, jam, dll
            $table->json('specifications')->nullable(); // Spesifikasi JSON
            $table->json('gallery')->nullable(); // Array gambar JSON
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_services');
    }
};