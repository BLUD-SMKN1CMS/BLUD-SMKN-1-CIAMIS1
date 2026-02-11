<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalService extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'service_type',
        'rental_date',
        'return_date',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Get the latest payment
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    // Check if rental has completed payment
    public function hasCompletedPayment()
    {
        return $this->payments()->where('status', 'completed')->exists();
    }
}
