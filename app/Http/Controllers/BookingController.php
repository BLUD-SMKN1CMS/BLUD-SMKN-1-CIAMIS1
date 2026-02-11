<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'rental_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:rental_date',
            'payment_method' => 'required|in:cash,transfer,e-wallet',
            'ewallet_type' => 'required_if:payment_method,e-wallet|nullable|in:OVO,Dana,GoPay',
            'notes' => 'nullable|string',
        ]);

        // Get service details
        $service = \App\Models\Service::findOrFail($validated['service_id']);
        
        // Calculate rental duration and total amount
        $rentalDate = \Carbon\Carbon::parse($validated['rental_date']);
        $returnDate = \Carbon\Carbon::parse($validated['return_date']);
        $days = $rentalDate->diffInDays($returnDate);
        $totalAmount = $days * $service->price_per_day;

        // Create service booking record
        $booking = \App\Models\ServiceBooking::create([
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'service_type' => $service->name,
            'rental_date' => $validated['rental_date'],
            'return_date' => $validated['return_date'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Create payment record
        $payment = \App\Models\Payment::create([
            'rental_service_id' => $booking->id,
            'payment_method' => $validated['payment_method'],
            'ewallet_type' => $validated['ewallet_type'] ?? null,
            'amount' => $totalAmount,
            'status' => 'pending',
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('booking.success', $payment->transaction_id)
            ->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');
    }

    public function success($transactionId)
    {
        $payment = \App\Models\Payment::where('transaction_id', $transactionId)->firstOrFail();
        $payment->load('rentalService');
        
        // --- DATA FOOTER & LAYOUT ---
        // 1. Settings
        $settings = \App\Models\Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
            'whatsapp_message' => $settings['contact']['whatsapp_message'] ?? 'Halo, saya tertarik dengan layanan BLUD SMKN 1 Ciamis',
            'opening_hours_weekdays' => $settings['hours']['opening_hours_weekdays'] ?? 'Senin - Jumat: 08:00 - 16:00',
            'opening_hours_saturday' => $settings['hours']['opening_hours_saturday'] ?? 'Sabtu: 08:00 - 14:00',
            'opening_hours_sunday' => $settings['hours']['opening_hours_sunday'] ?? 'Minggu & Hari Libur Nasional: Tutup',
        ];

        // 2. Social Media
        $socialMedia = [
            'facebook' => $settings['social']['facebook_url'] ?? '#',
            'instagram' => $settings['social']['instagram_url'] ?? '#',
            'youtube' => $settings['social']['youtube_url'] ?? '#',
            'tiktok' => $settings['social']['tiktok_url'] ?? '#',
            'twitter' => $settings['social']['twitter_url'] ?? '#',
        ];

        // 3. Footer Links
        $footerServices = \App\Models\Service::where('status', 'available')->limit(3)->get();
        $footerTefas = \App\Models\Tefa::where('is_active', true)->orderBy('order')->get();
        // ---------------------------
        
        return view('booking.success', compact(
            'payment', 
            'contactInfo', 
            'socialMedia', 
            'footerServices', 
            'footerTefas'
        ));
    }
}
