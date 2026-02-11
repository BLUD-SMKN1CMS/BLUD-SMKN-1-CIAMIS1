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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_service_id')->constrained('service_bookings')->onDelete('cascade');
            $table->string('payment_method'); // cash, transfer, e-wallet
            $table->string('ewallet_type')->nullable(); // OVO, Dana, GoPay
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, completed, failed, cancelled
            $table->string('transaction_id')->nullable();
            $table->text('payment_proof')->nullable(); // for transfer payments
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
