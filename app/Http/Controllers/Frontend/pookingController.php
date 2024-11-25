<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Received booking request', $request->all());

        try {
            $validated = $request->validate([
                'unite_id' => 'required|exists:unites,id',
                'name' => 'required|string',
                'phone' => 'required',
                'email' => 'required|email',
                'notes' => 'nullable|string'
            ]);

            $booking = Booking::create([
                'unite_id' => $validated['unite_id'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending'
            ]);

            Log::info('Booking created successfully', ['booking_id' => $booking->id]);
            return response()->json([
                'success' => true,
                'message' => 'تم الحجز بنجاح',
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في عملية الحجز: ' . $e->getMessage()
            ], 500);
        }
    }
}