<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Booking request received', ['data' => $request->all()]);

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'unite_id' => 'required|exists:unites,id',
                'name' => 'required|string',
                'phone' => 'required',
                'email' => 'required|email',
                'notes' => 'nullable|string'
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            $booking = Booking::create([
                'unite_id' => $validated['unite_id'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending'
            ]);

            DB::commit();

            Log::info('Booking created successfully', ['booking' => $booking]);

            return response()->json([
                'success' => true,
                'message' => 'تم الحجز بنجاح',
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في عملية الحجز',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}