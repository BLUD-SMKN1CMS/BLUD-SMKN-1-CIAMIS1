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
        Schema::table('admins', function (Blueprint $table) {
            // Ubah role dari string menjadi enum
            \DB::statement("ALTER TABLE admins MODIFY COLUMN role ENUM('super-admin', 'admin-tefa') DEFAULT 'admin-tefa'");

            // Tambah tefa_id
            $table->foreignId('tefa_id')->nullable()->after('role')->constrained('tefas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['tefa_id']);
            $table->dropColumn('tefa_id');

            // Kembalikan role menjadi string
            \DB::statement("ALTER TABLE admins MODIFY COLUMN role VARCHAR(255) DEFAULT 'admin'");
        });
    }
};
