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
            $table->string('icon')->default('fas fa-school')->after('slug');
            $table->json('services')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tefas', function (Blueprint $table) {
            $table->dropColumn(['icon', 'services']);
        });
    }
};
