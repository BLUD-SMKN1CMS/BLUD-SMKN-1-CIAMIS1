<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'company_address', 'company_phone', etc
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // 'contact', 'social', 'system'
            $table->string('type')->default('text'); // 'text', 'textarea', 'number', 'email', 'url'
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};