<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Unite;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('unite')->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unite_id' => 'required|exists:unites,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        try {
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

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'tenant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'booking_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'تم تحديث الحجز بنجاح');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'تم حذف الحجز بنجاح');
    }
}
