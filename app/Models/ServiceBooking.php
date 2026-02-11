<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $fillable = [
        'service_id',
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

    // Relationship with Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class, 'rental_service_id');
    }

    // Get the latest payment
    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'rental_service_id')->latestOfMany();
    }

    // Check if booking has completed payment
    public function hasCompletedPayment()
    {
        return $this->payments()->where('status', 'completed')->exists();
    }
}
