<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'total_students', 'total_products', etc
            $table->string('label'); // 'Siswa', 'Produk', etc
            $table->bigInteger('value')->default(0);
            $table->string('icon')->nullable(); // 'fa-users', 'fa-box', etc
            $table->string('suffix')->default(''); // '+', '%', 'jt', etc
            $table->boolean('is_auto')->default(false); // true = hitung otomatis, false = manual
            $table->string('auto_source')->nullable(); // 'products', 'tefas', 'services'
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('statistics');
    }
};