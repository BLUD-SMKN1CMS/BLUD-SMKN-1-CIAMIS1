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
        Schema::table('tefas', function (Blueprint $table) {
            $table->text('about')->nullable()->after('description'); // Tentang jurusan (detail lengkap)
            $table->text('vision')->nullable()->after('about'); // Visi jurusan
            $table->text('mission')->nullable()->after('vision'); // Misi jurusan
            $table->string('video_url')->nullable()->after('mission'); // URL video profil (YouTube/Vimeo)
            $table->json('job_prospects')->nullable()->after('video_url'); // Prospek kerja (array)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tefas', function (Blueprint $table) {
            $table->dropColumn(['about', 'vision', 'mission', 'video_url', 'job_prospects']);
        });
    }
};
