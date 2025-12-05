<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tefa_id')->constrained('tefas')->onDelete('cascade');
            $table->string('name'); // Ganti dari 'nama_produk' ke 'name'
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('category');
            $table->string('image')->nullable();
            $table->integer('stock')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};