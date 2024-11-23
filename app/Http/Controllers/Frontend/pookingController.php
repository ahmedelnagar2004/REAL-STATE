<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Unite;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'unite_id' => 'required|exists:unites,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email',
                'notes' => 'nullable|string',
            ]);

            $validated['status'] = 'pending';

            $booking = Booking::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'تم الحجز بنجاح',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحجز',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}