<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\RentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('rentalService')
            ->latest()
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rentalServices = RentalService::whereDoesntHave('payments', function($query) {
            $query->where('status', 'completed');
        })->get();

        return view('payments.create', compact('rentalServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_service_id' => 'required|exists:rental_services,id',
            'payment_method' => 'required|in:cash,transfer,e-wallet',
            'ewallet_type' => 'required_if:payment_method,e-wallet|nullable|in:OVO,Dana,GoPay',
            'amount' => 'required|numeric|min:0',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $validated['payment_proof'] = $path;
        }

        // Set initial status
        $validated['status'] = 'pending';
        
        // Generate transaction ID
        $validated['transaction_id'] = 'TRX-' . strtoupper(uniqid());

        $payment = Payment::create($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('rentalService');
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $rentalServices = RentalService::all();
        return view('payments.edit', compact('payment', 'rentalServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'rental_service_id' => 'required|exists:rental_services,id',
            'payment_method' => 'required|in:cash,transfer,e-wallet',
            'ewallet_type' => 'required_if:payment_method,e-wallet|nullable|in:OVO,Dana,GoPay',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($payment->payment_proof && Storage::disk('public')->exists($payment->payment_proof)) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $validated['payment_proof'] = $path;
        }

        // Set paid_at timestamp if status is completed
        if ($validated['status'] === 'completed' && !$payment->paid_at) {
            $validated['paid_at'] = now();
        }

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Delete payment proof if exists
        if ($payment->payment_proof && Storage::disk('public')->exists($payment->payment_proof)) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }

    /**
     * Confirm payment (mark as completed)
     */
    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment confirmed successfully!');
    }

    /**
     * Cancel payment
     */
    public function cancel(Payment $payment)
    {
        $payment->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment cancelled successfully!');
    }
}
