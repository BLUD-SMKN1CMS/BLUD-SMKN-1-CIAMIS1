<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price_per_hour', 12, 2)->nullable();
            $table->decimal('price_per_day', 12, 2)->nullable();
            $table->integer('capacity')->nullable();
            $table->string('unit')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};